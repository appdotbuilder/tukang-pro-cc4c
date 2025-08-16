<?php

namespace App\Http\Controllers;

use App\Models\CraftsmanProfile;
use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    /**
     * Display search results for craftsmen.
     */
    public function index(Request $request)
    {
        $skillFilter = $request->get('skill');
        $locationFilter = $request->get('location');
        $ratingFilter = $request->get('rating', 0);

        $craftsmenQuery = CraftsmanProfile::with(['user', 'skills.skill', 'skills.certification'])
            ->verified()
            ->available();

        if ($skillFilter) {
            $craftsmenQuery->whereHas('skills.skill', function ($query) use ($skillFilter) {
                $query->where('name', 'like', "%{$skillFilter}%");
            });
        }

        if ($locationFilter) {
            $craftsmenQuery->where('location', 'like', "%{$locationFilter}%");
        }

        if ($ratingFilter > 0) {
            $craftsmenQuery->where('rating', '>=', $ratingFilter);
        }

        $craftsmen = $craftsmenQuery->orderBy('rating', 'desc')->paginate(12);

        $skills = Skill::active()->orderBy('name')->get();

        return Inertia::render('search', [
            'craftsmen' => $craftsmen,
            'skills' => $skills,
            'filters' => [
                'skill' => $skillFilter,
                'location' => $locationFilter,
                'rating' => $ratingFilter,
            ]
        ]);
    }
}