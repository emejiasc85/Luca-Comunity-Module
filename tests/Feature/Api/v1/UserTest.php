<?php

namespace Tests\Feature\Api\v1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase{
    
    use RefreshDatabase;

    function test_list_users()
    {

        $user = $this->signIn();

        $this->getJson('api/v1/users')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'     => $user->id,
                        'age'    => $user->age,
                        'name'   => $user->name,
                        'email'  => $user->email,
                        'gender' => [
                            'id'   => $user->gender_id,
                            'name' => $user->gender->name
                        ]
                    ]
                ]
            ]);
    }
    
    function test_filter_users_by_keyword()
    {

        $user = $this->signIn(['name' => 'Juan Campos']);

        $otherUser = User::factory()->create(['name' => 'Enrique Mejias']);

        $parameters = [
            'search' =>  'mejias'
        ];

        $this->call('GET','api/v1/users', $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id'     => $otherUser->id,
                        'age'    => $otherUser->age,
                        'name'   => $otherUser->name,
                        'email'  => $otherUser->email,
                        'gender' => [
                            'id'   => $otherUser->gender_id,
                            'name' => $otherUser->gender->name
                        ]
                    ]
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    0 => [
                        'id'     => $user->id,
                        'age'    => $user->age,
                        'name'   => $user->name,
                        'email'  => $user->email,
                        'gender' => [
                            'id'   => $user->gender_id,
                            'name' => $user->gender->name
                        ]
                    ]
                ]
            ]);
    }
    
    function test_show_user()
    {
        $user = $this->signIn();

        $this->getJson('api/v1/users/'.$user->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'     => $user->id,
                    'age'    => $user->age,
                    'name'   => $user->name,
                    'email'  => $user->email,
                    'gender' => [
                        'id'   => $user->gender_id,
                        'name' => $user->gender->name
                    ]
                ]
            ]);
    }
    
    function test_store_an_user()
    {
        $this->signIn();

        $data = User::factory()->make();

        $parameters = [
            'name'                  => $data->name,
            'age'                   => $data->age,
            'gender_id'             => $data->gender_id,
            'email'                 => $data->email,
            'password'              => 'password',
            'password_confirmation' => 'password'
        ];

        $this->postJson('api/v1/users/', $parameters)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'age'    => $data->age,
                    'name'   => $data->name,
                    'email'  => $data->email,
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'name'      => $data->name,
            'age'       => $data->age,
            'gender_id' => $data->gender_id,
            'email'     => $data->email,
        ]);
    }
    
    function test_validate_before_store_an_user()
    {
        $this->signIn();

        $parameters = [];

        $this->postJson('api/v1/users/', $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'age'       => ['El campo edad es obligatorio.'],
                    'name'      => ['El campo nombre es obligatorio.'],
                    'email'     => ['El campo correo electrónico es obligatorio.'],
                    'gender_id' => ['El campo genero es obligatorio.'],
                    'password'  => ['El campo contraseña es obligatorio.']
                ]
            ]);
    }
    
    function test_update_an_user()
    {
        $this->signIn();

        $user = User::factory()->create();
        $data = User::factory()->make();

        $parameters = [
            'name'      => $data->name,
            'age'       => $data->age,
            'gender_id' => $data->gender_id,
            'email'     => $data->email,
        ];

        $this->putJson('api/v1/users/'.$user->id, $parameters)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'     => $user->id,
                    'age'    => $data->age,
                    'name'   => $data->name,
                    'email'  => $data->email,
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'id'        => $user->id,
            'name'      => $data->name,
            'age'       => $data->age,
            'gender_id' => $data->gender_id,
            'email'     => $data->email,
        ]);
    }
    
    function test_validate_before_update_a_user()
    {
        $this->signIn();

        $user = User::factory()->create();

        $parameters = [];

        $this->putJson('api/v1/users/'.$user->id, $parameters)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'age'       => ['El campo edad es obligatorio.'],
                    'name'      => ['El campo nombre es obligatorio.'],
                    'email'     => ['El campo correo electrónico es obligatorio.'],
                    'gender_id' => ['El campo genero es obligatorio.'],
                ]
            ]);
    }
    
    function test_destroy_an_user()
    {
        $this->signIn();

        $user = User::factory()->create();


        $this->deleteJson('api/v1/users/'.$user->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);
    }

}