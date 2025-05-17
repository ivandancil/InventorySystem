<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class RequestSentToWarehouse extends Notification
{
    public $requestDetails;

    // Pass request details to the notification
    public function __construct($requestDetails)
    {
        $this->requestDetails = $requestDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Store the notification in the database
    }

    /**
     * Get the data array that represents the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => "A new request has been sent to the warehouse: " . $this->requestDetails['message'],
            'url' => $this->requestDetails['url'], // Optional: a link to view more details
        ];
    }
}
