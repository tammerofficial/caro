<?php

namespace Core\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mailData;
    protected $form_name;
    protected $form_email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $form_email, $form_name)
    {
        $this->mailData = $mailData;
        $this->form_email = $form_email;
        $this->form_name = $form_name;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailData['subject'])->view('core::base.email.email_templates.global_mail_template', [
            'template_id' => $this->mailData['template_id'],
            'data' => $this->mailData,
            'keywords' => $this->mailData['keywords']
        ])->from($this->form_email, $this->form_name);
    }
}
