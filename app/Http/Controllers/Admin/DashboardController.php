<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_ads' => Advertisement::count(),
            'pending_ads' => Advertisement::where('status', 'pending')->count(),
            'approved_ads' => Advertisement::where('status', 'approved')->count(),
            'rejected_ads' => Advertisement::where('status', 'rejected')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentAds = Advertisement::with('user')->latest()->take(5)->get();

        $userGrowth = $this->getUserGrowth();
        $adGrowth = $this->getAdGrowth();
        $adStatusDistribution = $this->getAdStatusDistribution();
        $popularMakes = $this->getPopularMakes();
        $priceDistribution = $this->getPriceDistribution();

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentAds',
            'userGrowth',
            'adGrowth',
            'adStatusDistribution',
            'popularMakes',
            'priceDistribution'
        ));
    }

    private function getUserGrowth()
    {
        return User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getAdGrowth()
    {
        return Advertisement::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getAdStatusDistribution()
    {
        return Advertisement::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
    }

    private function getPopularMakes()
    {
        return DB::table('cars')
            ->select('make', DB::raw('count(*) as count'))
            ->groupBy('make')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();
    }

    private function getPriceDistribution()
    {
        return Advertisement::select(
            DB::raw('CASE 
                WHEN price < 10000 THEN "Under $10k"
                WHEN price < 20000 THEN "$10k - $20k"
                WHEN price < 30000 THEN "$20k - $30k"
                WHEN price < 40000 THEN "$30k - $40k"
                ELSE "Over $40k"
            END as range'),
            DB::raw('count(*) as count')
        )
        ->groupBy('range')
        ->orderBy('range')
        ->get();
    }
} 