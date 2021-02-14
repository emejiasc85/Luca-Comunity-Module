<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table   = 'questions';
    protected $guarded = [];

    /* relations */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignment()
    {
        return $this->belongsTo(CourseAssignment::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        return $this->hasMany(QuestionFavorite::class);
    }
    
    public function follows()
    {
        return $this->hasMany(QuestionFollow::class);
    }
    
    public function likes()
    {
        return $this->hasMany(QuestionLike::class);
    }

    public function dislikes()
    {
        return $this->hasMany(QuestionDislike::class);
    }

    /* scopes */
    
    public function scopeSearch($query)
    {
        return $query->when(request()->filled('search'), function($query){
            $query->where('qustions', 'LIKE', '%'.request()->search.'%')
                ->orWhere('description', 'LIKE', '%'.request()->search.'%');
        });
    }

    public function scopeOrdered($query)
    {
        $query->when(request()->filled('order_by'), function($query){
            $query->orderBy(request()->order_by, request()->order);
        });
    }
    
    public function scopeFollowed($query)
    {
        $query->when(request()->filled('followed'), function($query){
            $query->whereHas('follows', function($query){
                $query->where('user_id', auth()->id());
            });
        });
    }
}
