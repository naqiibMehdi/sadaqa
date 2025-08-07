<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
  protected $fillable = ["email", "description", "status"];

  protected function email(): Attribute
  {
    return Attribute::make(
      set: fn($value) => strtolower($value)
    );
  }
}
