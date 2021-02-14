<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Notification;

class QuestionLike extends Model
{
    use HasFactory;

    protected $table   = 'question_likes';
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

    /* methods */

    public function sendNotification()
    {

        $subject = 'Tu pregunta ha obtenido un me gusta';

        $content = $this->user->name.' Le ha dado me gusta a tu pregunta.';

        Notification::send([$this->question->user], new EmailNotification($subject, $content));

        return $this;
    }
}
