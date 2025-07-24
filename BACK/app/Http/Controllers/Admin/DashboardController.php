<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    // Statistiques pour le dashboard
    $stats = [
      'users' => User::count(),
      'total_donations' => $this->getTotalDonations(),
      'active_campaigns' => $this->getActiveCampaigns(),
      'monthly_donations' => $this->getMonthlyDonations(),
    ];

    // Données récentes
    $recent_donations = $this->getRecentDonations();
    $recent_campaigns = $this->getRecentCampaigns();

    return view('admin.dashboard', compact('stats', 'recent_donations', 'recent_campaigns'));
  }

  private function getTotalDonations()
  {
    // Ajustez selon votre structure de base de données
    try {
      return DB::table('donations')->sum('amount') ?? 0;
    } catch (\Exception $e) {
      return 0;
    }
  }

  private function getActiveCampaigns()
  {
    try {
      return Campaign::whereNull('closing_date')
        ->count();
    } catch (\Exception $e) {
      return 0;
    }
  }

  private function getMonthlyDonations()
  {
    try {
      return DB::table('donations')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('amount') ?? 0;
    } catch (\Exception $e) {
      return 0;
    }
  }

  private function getRecentDonations()
  {
    try {
      return DB::table('donations')
        ->join('users', 'donations.user_id', '=', 'users.id')
        ->leftJoin('campaigns', 'donations.campaign_id', '=', 'campaigns.id')
        ->select('donations.*', 'users.name as user_name', 'campaigns.title as campaign_title')
        ->orderBy('donations.created_at', 'desc')
        ->limit(5)
        ->get()
        ->map(function ($donation) {
          $donation->user = (object)['name' => $donation->user_name];
          $donation->campaign = (object)['title' => $donation->campaign_title];
          $donation->created_at = now()->parse($donation->created_at);
          return $donation;
        });
    } catch (\Exception $e) {
      return collect();
    }
  }

  private function getRecentCampaigns()
  {
    try {
      return DB::table('campaigns')
        ->select('campaigns.*', DB::raw('COALESCE(SUM(donations.amount), 0) as raised'))
        ->leftJoin('donations', 'campaigns.id', '=', 'donations.campaign_id')
        ->groupBy('campaigns.id')
        ->orderBy('campaigns.created_at', 'desc')
        ->limit(5)
        ->get();
    } catch (\Exception $e) {
      return collect();
    }
  }
}
