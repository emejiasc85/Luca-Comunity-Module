<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionFollow extends Model
{
    use HasFactory;

    protected $table   = 'question_follows';
    protected $guarded = [];

    /* relations */

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
