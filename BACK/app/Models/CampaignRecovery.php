<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignRecovery extends Model
{
  protected $fillable = ["campaign_id", "user_id", "amount", "amount_assoc", "total_amount", "status", "iban"];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function campaign(): BelongsTo
  {
    return $this->belongsTo(Campaign::class);
  }
}
