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
    Mail::to($this->customerEmail)->send($this->event);
  }
}
