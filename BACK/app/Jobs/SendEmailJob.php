<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new job instance.
   */
  public function __construct(protected string $customerEmail, protected Mailable $event)
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $mail = Mail::to($this->customerEmail);

    if (env("ADMIN_BCC_EMAIL")) {
      $mail->bcc(env("ADMIN_BCC_EMAIL"));
    }

    $mail->send($this->event);
  }
}
