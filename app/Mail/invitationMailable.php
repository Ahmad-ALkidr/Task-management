<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class invitationMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $invitation_id;
    public $email ;
    public $project_name ;



    public function __construct($invitation_id , $email , $project_name)
    {
        //
        $this->invitation_id = $invitation_id;
        $this->email = $email;
        $this->project_name = $project_name;

    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Mail',
        );
    }

    //  The page that will be displayed to the user in an email
    public function build()
    {
        return $this->view('emails.invitation_plain')
                    ->subject('Verification Code');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
