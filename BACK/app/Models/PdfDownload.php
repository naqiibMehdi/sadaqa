<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PdfDownload extends Model
{
  protected $fillable = [
    "user_id",
    "campaign_id",
    "document_type",
    "filename",
    "ip_address",
    "user_agent",
    "downloaded_at"
  ];

  protected $casts = [
    "downloaded_at" => "datetime"
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function campaign(): BelongsTo
  {
    return $this->belongsTo(Campaign::class);
  }
}
