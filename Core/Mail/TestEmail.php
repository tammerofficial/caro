<?php

namespace Core\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (isTenant()) {
            changeEmailConfiguration();

            $mail_form_name = getGeneralSetting('mail_from_name');
            $mail_form_email = getGeneralSetting('mail_from');


            $form_name = !empty($mail_form_email) ? $mail_form_name : env('MAIL_FROM_NAME');
            $form_email = !empty($mail_form_email) ? $mail_form_email : env('MAIL_FROM_ADDRESS');
        } else {
            $form_name =  env('MAIL_FROM_NAME');
            $form_email = env('MAIL_FROM_ADDRESS');
        }

        return $this->subject($this->mailData['subject'])->view('core::base.email.smtp.test_mail')
            ->from($form_email, $form_name);
    }
}
