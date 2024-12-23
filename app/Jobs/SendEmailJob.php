<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\YourMailable; // Thay thế bằng mailable của bạn

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;

    public function __construct($emailData) {
        $this->emailData = $emailData;
    }

    public function handle() {
        try {
            // Mail::to($this->emailData['to'])->send(new YourMailable($this->emailData));
            Log::info('Email sent successfully to: ' . $this->emailData['to']);
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
