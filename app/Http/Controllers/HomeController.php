<?php

namespace App\Http\Controllers;

use App\Models\CraftsmanProfile;
use App\Models\Skill;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(Request $request)
    {
        $skillFilter = $request->get('skill');
        $locationFilter = $request->get('location');

        // Get featured craftsmen
        $craftsmenQuery = CraftsmanProfile::with(['user', 'skills.skill', 'skills.certification'])
            ->verified()
            ->available()
            ->orderBy('rating', 'desc');

        if ($skillFilter) {
            $craftsmenQuery->whereHas('skills.skill', function ($query) use ($skillFilter) {
                $query->where('name', 'like', "%{$skillFilter}%");
            });
        }

        if ($locationFilter) {
            $craftsmenQuery->where('location', 'like', "%{$locationFilter}%");
        }

        $featuredCraftsmen = $craftsmenQuery->limit(6)->get();

        // Get all skills for search dropdown
        $skills = Skill::active()->orderBy('name')->get();



        // Get stats for the homepage
        $stats = [
            'total_craftsmen' => CraftsmanProfile::verified()->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'completed_jobs' => ServiceRequest::completed()->count(),
            'average_rating' => CraftsmanProfile::avg('rating') ?: 0,
        ];

        return Inertia::render('welcome', [
            'featuredCraftsmen' => $featuredCraftsmen,
            'skills' => $skills,
            'stats' => $stats,
            'filters' => [
                'skill' => $skillFilter,
                'location' => $locationFilter,
            ]
        ]);
    }


}