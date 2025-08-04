<?php

namespace App\Helpers;

class UrlHelper
{
  public static function assetUrl($path)
  {
    if (env('USE_FRONTEND_URL', false)) {
      return env('FRONTEND_URL') . '/' . trim($path, '/');
    }
    return asset($path);
  }
}
