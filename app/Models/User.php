<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'gender_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /* mutators */

    public function setPasswordAttribute($value)
    {
        if($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
    
    /* relations */

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    /* scopes */

    public function scopeSearch($query)
    {
        return $query->when(request()->filled('search'), function($query){
            $query->where('name', 'LIKE', '%'.request()->search.'%')
                ->orWhere('email', 'LIKE', '%'.request()->search.'%');
        });
    }
}
