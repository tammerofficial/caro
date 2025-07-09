<?php

namespace Core\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class OrderStatusUpdateMail extends Mailable implements ShouldQueue
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
        $request = app('request');
        $current_domain = $request->getHost();
        $this->mailData['current_domain'] = $current_domain;
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

        return $this->subject($this->mailData['subject'])->view('core::base.email.email_templates.global_mail_template', ['template_id' => $this->mailData['template_id'], 'data' => $this->mailData, 'keywords' => $this->mailData['keywords']])
            ->from($form_email, $form_name);
    }
}
