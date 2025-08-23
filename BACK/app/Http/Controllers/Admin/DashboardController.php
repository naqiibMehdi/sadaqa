<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index(): Factory|Application|View
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
      return Participant::where("payment_status", "completed")->sum("amount") ?? 0;
    } catch (\Exception $e) {
      return 0;
    }
  }

  private function getActiveCampaigns()
  {
    try {
      return Campaign::whereNull('closing_date')->count();
    } catch (\Exception $e) {
      return 0;
    }
  }

  private function getMonthlyDonations()
  {
    try {
      return Participant::query()
        ->whereMonth('participation_date', now()->month)
        ->whereYear('participation_date', now()->year)
        ->where("payment_status", "completed")
        ->sum('amount') ?? 0;
    } catch (\Exception $e) {
      return 0;
    }
  }

  private function getRecentDonations(): Collection|\Illuminate\Support\Collection
  {
    try {
      return Participant::with("campaign")->orderBy("participation_date", "desc")->limit(5)->get();
    } catch (\Exception $e) {
      return collect();
    }
  }

  private function getRecentCampaigns(): Collection|\Illuminate\Support\Collection
  {
    try {
      return Campaign::query()->orderBy("created_at", "desc")->limit(5)->get();
    } catch (\Exception $e) {
      return collect();
    }
  }
}
