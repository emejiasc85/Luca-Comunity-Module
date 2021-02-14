<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailNotification extends Notification
{
    public $subject;
    public $content;
    public $url;
    public $urlMessage;
    public $file;

    public function __construct($subject, $content, $url = false, $urlMessage = null, $file = null)
    {
        $this->subject    = $subject;
        $this->content    = $content;
        $this->url        = $url;
        $this->urlMessage = $urlMessage;
        $this->file       = $file;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject($this->subject)
            ->line($this->content);

        if($this->url) {
            $message->action($this->urlMessage, $this->url);
        }

        if($this->file) {
            $message->attach($this->file->path);
        }

        return $message;
    }

}
