<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests\TestSupport\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Wnx\Sends\Tests\TestSupport\Models\TestModel;

class TestNotification extends Notification
{
    public TestModel $user;

    public function __construct(public TestModel $testModel)
    {
    }

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
        return (new MailMessage())
            ->success()
            ->subject('::subject-of-notification::')
            ->line('::notifcation-line::');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
