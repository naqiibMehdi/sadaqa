<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $table = 'users';

  protected $guarded = ["id"];


  protected $hidden = ["password"];

  protected $casts = [
    "subscribe_date" => "datetime",
    "birth_date" => "datetime",
  ];

  public $timestamps = false;

  protected function email(): Attribute
  {
    return Attribute::make(
      set: fn($value) => strtolower($value),
    );
  }

  protected function name(): Attribute
  {
    return Attribute::make(
      get: fn($value) => strtoupper($value),
    );
  }

  public function address(): HasOne
  {
    return $this->hasOne(Address::class);
  }

  public function campaign(): HasMany
  {
    return $this->hasMany(Campaign::class);
  }

  public function iban(): HasOne
  {
    return $this->hasOne(Iban::class);
  }

  public function recoveries(): HasMany
  {
    return $this->hasMany(CampaignRecovery::class);
  }
}
