<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    private $webAppUrl;

    public function __construct($token)
    {
        $this->webAppUrl = config('app.web_url');;
        parent::__construct($token);
    }

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $webAppUrl = rtrim($this->webAppUrl, '/');

        $url = $webAppUrl . route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false);

        return $this->buildMailMessage($url);
    }
}
