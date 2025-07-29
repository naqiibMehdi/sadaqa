<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
  protected $table = "participants";

  protected $guarded = ["id"];

  public $timestamps = false;

  protected $casts = [
    "participation_date" => "datetime"
  ];

  public function campaign(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Campaign::class);
  }
}
