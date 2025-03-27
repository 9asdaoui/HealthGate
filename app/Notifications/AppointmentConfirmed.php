<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $doctorName = $this->appointment->doctor->user->first_name . ' ' . 
                     $this->appointment->doctor->user->last_name;
                     
        return (new MailMessage)
                    ->subject('Appointment Confirmed')
                    ->greeting('Hello ' . $notifiable->first_name . '!')
                    ->line('Your appointment has been confirmed by Dr. ' . $doctorName)
                    ->line('Appointment Details:')
                    ->line('Date: ' . $this->appointment->appointment_date)
                    ->line('Time: ' . $this->appointment->appointment_time)
                    ->line('Reason: ' . $this->appointment->reason)
                    ->action('View Appointment', url('/patient/appointments'))
                    ->line('Thank you for using HealthGate!');
    }
}