<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
  private string $url = "https://saddaqa.fr";

  public function handle(): ResponseFactory|string
  {
    $sitemap = Sitemap::create();

    // Sitemap principal
    $this->addStaticPages($sitemap);

    // Sitemap des campagnes
    $this->addCampaigns($sitemap);

    $sitemap->writeToFile(public_path("sitemap.xml"));

    return response($sitemap->render(), 200, ["Content-Type" => "text/xml"]);
  }

  /**
   * Ajoute les pages statiques au sitemap
   */
  private function addStaticPages(Sitemap $sitemap): void
  {
    // Page d'accueil
    $sitemap->add(Url::create($this->url)
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
      ->setPriority(1.0));

    // Pages publiques principales
    $sitemap->add(Url::create($this->url . "/campaigns")
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
      ->setPriority(0.9));

    $sitemap->add(Url::create($this->url . "/contact")
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
      ->setPriority(0.7));

    $sitemap->add(Url::create($this->url . "/privacy-policy")
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
      ->setPriority(0.5));

    // Pages d'authentification
    $sitemap->add(Url::create($this->url . "/login")
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
      ->setPriority(0.8));

    $sitemap->add(Url::create($this->url . "/register")
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
      ->setPriority(0.8));

    $sitemap->add(Url::create($this->url . "/forget-password")
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
      ->setPriority(0.6));

    $sitemap->add(Url::create($this->url . "/reset-password")
      ->setLastModificationDate(now())
      ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
      ->setPriority(0.6));
  }

  /**
   * Ajoute les campagnes au sitemap
   */
  private function addCampaigns(Sitemap $sitemap): void
  {
    // Récupérez toutes les campagnes publiées
    $campaigns = Campaign::all();

    foreach ($campaigns as $campaign) {
      $sitemap->add(Url::create($this->url . "/campaigns/{$campaign->slug}-{$campaign->id}")
        ->setLastModificationDate(Carbon::parse($campaign->updated_at))
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.8));
    }
  }
}
