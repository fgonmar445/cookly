<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    public function toMail($notifiable)
    {
        // Generar URL de verificación
        $verificationUrl = $this->verificationUrl($notifiable);

        // Usar tu plantilla personalizada
        return (new MailMessage)
            ->subject('Verifica tu cuenta en Cookly')
            ->view(
                'emails.verify', // Vista personalizada
                ['verification_url' => $verificationUrl]
            );
    }
}
