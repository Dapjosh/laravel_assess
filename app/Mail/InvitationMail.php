<?php

namespace App\Mail;

use App\Models\Invitations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $invitations;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invitations $invitations)
    {
        $this->invitations = $invitations;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invitations')->with([
            'invitation_link' => $this->invitations->getLink()
        ]);
    }
}
