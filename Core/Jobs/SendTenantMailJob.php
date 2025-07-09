<?php

namespace Core\Jobs;

use Core\Mail\TenantMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTenantMailJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue, Dispatchable;

    protected $mail_data;
    protected $recipientEmail;
    protected $config;

    public function __construct($recipientEmail, $mail_data, $config)
    {
        $this->mail_data = $mail_data;
        $this->recipientEmail = $recipientEmail;
        $this->config = $config;
    }

    public function handle()
    {
        // Set tenant-specific mail configuration
        Config::set('mail.mailers.smtp.host', $this->config['host']);
        Config::set('mail.mailers.smtp.port', $this->config['port']);
        Config::set('mail.mailers.smtp.username', $this->config['username']);
        Config::set('mail.mailers.smtp.password', $this->config['password']);
        Config::set('mail.mailers.smtp.encryption', $this->config['encryption']);
        Config::set('mail.from.address', $this->config['mail_from']);
        Config::set('mail.from.name', $this->config['mail_from_name']);

        // Send mail using tenant's mail config
        Mail::to($this->recipientEmail)->send(new TenantMail($this->mail_data, $this->config['mail_from'], $this->config['mail_from_name']));
    }
}
