<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CustomNotification extends Notification
{
    use Queueable;

    public $title;
    public $body;
    public $icon;
    public $description;
    public $file;

    public function __construct($type, $title, $body, $description, $file = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->description = $description;
        $this->file = $file;
        switch ($type) {
            case 'deposit':
                $this->icon = '<div class="icon icon-sm"><i data-feather="corner-right-down"></i></div>';
                break;
            case 'withdrawal':
                $this->icon = '<div class="icon icon-sm"><i data-feather="corner-down-left"></i></div>';
                break;
            case 'investment':
                $this->icon = '<div class="icon icon-sm"><i data-feather="layers"></i></div>';
                break;
            case 'savings':
                $this->icon = '<div class="icon icon-sm"><i data-feather="money"></i></div>';
                break;
            case 'trade':
                $this->icon = '<div class="icon icon-sm"><i data-feather="trending-up"></i></div>';
                break;
            case 'referral':
                $this->icon = '<div class="icon icon-sm"><i data-feather="users"></i></div>';
                break;
            case 'success':
                $this->icon = '<div class="icon icon-sm"><i data-feather="check-circle"></i></div>';
                break;
            case 'pending':
                $this->icon = '<div class="icon icon-sm"><i data-feather="alert-circle"></i></div>';
                break;
            case 'cancelled':
                $this->icon = '<div class="icon icon-sm"><i data-feather="x-circle"></i></div>';
                break;
            case 'default':
                $this->icon = '<div class="icon icon-sm"><i data-feather="bell"></i></div>';
                break;
        }
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'icon' => $this->icon,
            'description' => $this->description,
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        if ($this->file) {
            return (new MailMessage)
                ->subject($this->title)
                ->greeting('skip default')
                ->line('Hello '.$notifiable->name.',')
                ->line(new HtmlString($this->body))
                ->attachData($this->file, 'certificate.pdf');
        }
        return (new MailMessage)
            ->subject($this->title)
            ->greeting('skip default')
            ->line('Hello '.$notifiable->name.',')
            ->line(new HtmlString($this->body));
    }
}
