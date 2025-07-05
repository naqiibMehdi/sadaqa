<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Campaign extends Model
{
  use HasFactory;

  protected $table = "campaigns";

  protected $guarded = ["id"];

  protected $casts = [
    "is_anonymous" => "boolean"
  ];

  public $timestamps = false;

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  public function participant(): HasMany
  {
    return $this->hasMany(Participant::class);
  }

  public function recovery(): HasOne
  {
    return $this->hasOne(CampaignRecovery::class);
  }
}
