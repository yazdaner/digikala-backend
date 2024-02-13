<?php

namespace Modules\core\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\core\App\Mail\VerificationCode;

class SendVerificationCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $username;
    protected string $code;
    protected string|null $message;
    protected string|null $template;

    public function __construct($username, $code, $message, $template)
    {
        $this->username = $username;
        $this->code = $code;
        $this->message = $message;
        $this->template = $template;
    }

    public function handle(): void
    {
        if (filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            $this->sendEmail();
        } else {
            $this->sendSMS();
        }
    }

    protected function sendEmail()
    {
        $email = new VerificationCode($this->code);
        Mail::to($this->username)->send($email);
    }

    protected function sendSMS()
    {
        $webService = runEvent('setting:value','sms',true);
        runEvent($webService.'-send-sms',[
            'mobile' => $this->username,
            'template' => $this->template,
            'params' => [
                $this->code
            ]
        ]);
    }
}
