<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewGoogleUserJoined extends Notification
{
    use Queueable;

    protected User $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('New Google User Registered')
        ->line('A new user has registered using Google.')
        ->line('Name: ' . $this->user->name)
        ->line('Email: ' . $this->user->email)
        ->line('Username: ' . $this->user->username)
        ->line('Google ID: ' . $this->user->google_id);

    }
}