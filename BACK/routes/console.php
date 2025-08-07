<?php

//use Illuminate\Foundation\Inspiring;
//use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\SitemapController;
use \Illuminate\Support\Facades\Schedule;
use \Illuminate\Support\Facades\Log;

//Artisan::command('inspire', function () {
//  $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {
  (new SitemapController())->handle();
  Log::info("Sitemap generated");
})->timezone('Europe/Paris')->daily();
