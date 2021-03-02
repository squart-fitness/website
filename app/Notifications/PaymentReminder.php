<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification
{
    use Queueable;

    private $customer_name, $package_end_date, $customer_phone, $exp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($customer, $exp)
    {
        $this->customer_name = $customer->name;
        $this->package_end_date = $customer->package_end_date;
        $this->customer_phone = $customer->phone;  
        $this->exp = $exp; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'exp' => $this->exp,
            'name' => $this->customer_name,
            'phone' => $this->customer_phone,
            'package_end_date' => $this->package_end_date,
        ];
    }
}
