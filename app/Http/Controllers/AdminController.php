<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CraftsmanProfile;
use App\Models\ServiceRequest;
use App\Models\Skill;
use App\Models\Certification;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Display a listing of admin resources.
     */
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $stats = [
            'total_customers' => User::where('role', 'customer')->count(),
            'total_craftsmen' => User::where('role', 'craftsman')->count(),
            'verified_craftsmen' => CraftsmanProfile::verified()->count(),
            'pending_verification' => CraftsmanProfile::where('is_verified', false)->count(),
            'total_requests' => ServiceRequest::count(),
            'pending_requests' => ServiceRequest::where('status', 'pending')->count(),
            'completed_requests' => ServiceRequest::where('status', 'completed')->count(),
            'total_revenue' => ServiceRequest::where('status', 'completed')->sum('final_amount'),
            'average_rating' => Review::avg('rating'),
        ];

        $recentRequests = ServiceRequest::with(['customer', 'craftsman', 'skill'])
            ->latest()
            ->limit(10)
            ->get();

        $topCraftsmen = CraftsmanProfile::with('user')
            ->verified()
            ->orderBy('rating', 'desc')
            ->orderBy('total_reviews', 'desc')
            ->limit(10)
            ->get();

        return Inertia::render('admin/dashboard', [
            'stats' => $stats,
            'recentRequests' => $recentRequests,
            'topCraftsmen' => $topCraftsmen,
        ]);
    }

    /**
     * Show craftsmen management.
     */
    public function show(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $type = $request->route('admin') ?? 'dashboard';

        if ($type === 'craftsmen') {
            $query = CraftsmanProfile::with(['user', 'skills.skill']);

            if ($request->filter === 'pending') {
                $query->where('is_verified', false);
            } elseif ($request->filter === 'verified') {
                $query->where('is_verified', true);
            }

            $craftsmen = $query->latest()->paginate(15);

            return Inertia::render('admin/craftsmen', [
                'craftsmen' => $craftsmen,
                'filter' => $request->filter,
            ]);
        }

        if ($type === 'skills') {
            $skills = Skill::withCount('craftsmanSkills')
                ->orderBy('name')
                ->paginate(15);

            return Inertia::render('admin/skills', [
                'skills' => $skills,
            ]);
        }

        if ($type === 'certifications') {
            $certifications = Certification::withCount('craftsmanSkills')
                ->orderBy('level')
                ->paginate(15);

            return Inertia::render('admin/certifications', [
                'certifications' => $certifications,
            ]);
        }

        if ($type === 'reports') {
            $period = $request->get('period', '30'); // days

            // Revenue by month
            $revenueData = ServiceRequest::where('status', 'completed')
                ->where('completed_at', '>=', now()->subDays($period))
                ->selectRaw('DATE(completed_at) as date, SUM(final_amount) as revenue')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Top skills by request count
            $skillData = Skill::withCount(['serviceRequests' => function ($query) use ($period) {
                    $query->where('created_at', '>=', now()->subDays($period));
                }])
                ->orderBy('service_requests_count', 'desc')
                ->limit(10)
                ->get();

            // Craftsman earnings
            $earningsData = CraftsmanProfile::with('user')
                ->whereHas('user.craftsmanRequests', function ($query) use ($period) {
                    $query->where('status', 'completed')
                        ->where('completed_at', '>=', now()->subDays($period));
                })
                ->withSum(['user.craftsmanRequests' => function ($query) use ($period) {
                    $query->where('status', 'completed')
                        ->where('completed_at', '>=', now()->subDays($period));
                }], 'final_amount')
                ->orderBy('user_craftsman_requests_sum_final_amount', 'desc')
                ->limit(20)
                ->get();

            return Inertia::render('admin/reports', [
                'revenueData' => $revenueData,
                'skillData' => $skillData,
                'earningsData' => $earningsData,
                'period' => $period,
            ]);
        }

        // Default to dashboard
        return $this->index();
    }
}