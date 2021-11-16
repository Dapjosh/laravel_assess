<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendPinMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user_pin;

 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_pin)
    {
        $this->user_pin = $user_pin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.pin', [
            'data' => $this->Data()
        ]);
    }
    public function Data(){

      
        return [
            'register_link' =>urldecode(url('/api/user/register/final/').$this->user_pin),
            'pin' => $this->user_pin,
        ];

        Log::info('User Pin'.$this->user_pin);
    }
    
}
