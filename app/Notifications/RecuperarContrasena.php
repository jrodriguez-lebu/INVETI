<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecuperarContrasena extends Notification
{
    public function __construct(
        protected string $token
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Recuperación de contraseña — INVETI')
            ->greeting("Hola, {$notifiable->name}")
            ->line('Recibimos una solicitud para restablecer la contraseña de tu cuenta en **INVETI**.')
            ->line('Haz clic en el botón para crear una nueva contraseña:')
            ->action('Restablecer contraseña', $url)
            ->line('Este enlace expirará en **60 minutos**.')
            ->line('Si no solicitaste restablecer tu contraseña, puedes ignorar este correo. Tu cuenta permanece segura.')
            ->salutation('Municipalidad de Lebu — INVETI');
    }
}
