<?php

namespace App\Models;

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

  public $timestamps = false;

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
