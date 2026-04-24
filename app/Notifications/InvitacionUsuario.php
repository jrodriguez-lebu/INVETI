<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitacionUsuario extends Notification
{
    public function __construct(
        protected string $token,
        protected string $nombre
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('activar-cuenta.show', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Invitación a INVETI — Activa tu cuenta')
            ->greeting("Hola, {$this->nombre}")
            ->line('Has sido registrado en **INVETI**, el Sistema de Inventario Informático de la Municipalidad de Lebu.')
            ->line('Haz clic en el botón para activar tu cuenta y crear tu contraseña:')
            ->action('Activar mi cuenta', $url)
            ->line('Este enlace expirará en **60 minutos**.')
            ->line('Si no solicitaste este acceso, puedes ignorar este correo.')
            ->salutation('Municipalidad de Lebu — INVETI');
    }
}
