<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
  use HasFactory;

  protected $table = "campaigns";

  protected $guarded = ["id"];

  protected $casts = [
    "is_anonymous" => "boolean"
  ];

  public $timestamps = false;

  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  public function participant(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Participant::class);
  }
}
