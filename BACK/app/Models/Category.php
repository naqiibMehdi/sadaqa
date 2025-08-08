<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{

  use HasFactory;

  protected $table = "categories";

  protected $fillable = ["name", "translate_name"];

  public $timestamps = false;

  public function campaign(): HasMany
  {
    return $this->hasMany(Campaign::class);
  }
}
