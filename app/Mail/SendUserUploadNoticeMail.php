<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SendUserUploadNoticeMail extends Mailable
{
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->markdown('emails.client.send-user-upload-notice');
    }
}