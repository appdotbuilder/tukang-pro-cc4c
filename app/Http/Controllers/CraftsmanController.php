<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCraftsmanProfileRequest;
use App\Http\Requests\UpdateCraftsmanProfileRequest;
use App\Models\CraftsmanProfile;
use App\Models\Skill;
use App\Models\Certification;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CraftsmanController extends Controller
{
    /**
     * Display a listing of craftsmen.
     */
    public function index()
    {
        $craftsmen = CraftsmanProfile::with(['user', 'skills.skill', 'skills.certification'])
            ->verified()
            ->available()
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return Inertia::render('craftsmen/index', [
            'craftsmen' => $craftsmen
        ]);
    }

    /**
     * Show the form for creating a new craftsman profile.
     */
    public function create()
    {
        $skills = Skill::active()->get();
        $certifications = Certification::active()->get();

        return Inertia::render('craftsmen/create', [
            'skills' => $skills,
            'certifications' => $certifications
        ]);
    }

    /**
     * Store a newly created craftsman profile.
     */
    public function store(StoreCraftsmanProfileRequest $request)
    {
        $user = auth()->user();
        
        if ($user->role !== 'craftsman') {
            return redirect()->back()->with('error', 'Only craftsmen can create profiles.');
        }

        $profile = CraftsmanProfile::create([
            'user_id' => $user->id,
            'bio' => $request->bio,
            'years_experience' => $request->years_experience,
            'hourly_rate' => $request->hourly_rate,
            'location' => $request->location,
            'work_areas' => $request->work_areas,
            'insurance_rate' => $request->insurance_rate ?? 5.0,
        ]);

        // Attach skills with certifications
        if ($request->skills) {
            foreach ($request->skills as $skillData) {
                $profile->skills()->create([
                    'skill_id' => $skillData['skill_id'],
                    'certification_id' => $skillData['certification_id'] ?? null,
                ]);
            }
        }

        return redirect()->route('craftsmen.show', $profile)
            ->with('success', 'Craftsman profile created successfully.');
    }

    /**
     * Display the specified craftsman.
     */
    public function show(CraftsmanProfile $craftsman)
    {
        $craftsman->load(['user', 'skills.skill', 'skills.certification']);
        
        // Get recent reviews
        $reviews = $craftsman->user->receivedReviews()
            ->with(['customer', 'serviceRequest'])
            ->latest()
            ->limit(10)
            ->get();

        return Inertia::render('craftsmen/show', [
            'craftsman' => $craftsman,
            'reviews' => $reviews
        ]);
    }

    /**
     * Show the form for editing the craftsman profile.
     */
    public function edit(CraftsmanProfile $craftsman)
    {
        if (auth()->user()->id !== $craftsman->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $skills = Skill::active()->get();
        $certifications = Certification::active()->get();
        $craftsman->load(['skills.skill', 'skills.certification']);

        return Inertia::render('craftsmen/edit', [
            'craftsman' => $craftsman,
            'skills' => $skills,
            'certifications' => $certifications
        ]);
    }

    /**
     * Update the craftsman profile.
     */
    public function update(UpdateCraftsmanProfileRequest $request, CraftsmanProfile $craftsman)
    {
        if (auth()->user()->id !== $craftsman->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $craftsman->update($request->validated());

        // Update skills if provided
        if ($request->skills) {
            $craftsman->skills()->delete();
            foreach ($request->skills as $skillData) {
                $craftsman->skills()->create([
                    'skill_id' => $skillData['skill_id'],
                    'certification_id' => $skillData['certification_id'] ?? null,
                ]);
            }
        }

        return redirect()->route('craftsmen.show', $craftsman)
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the craftsman profile.
     */
    public function destroy(CraftsmanProfile $craftsman)
    {
        if (auth()->user()->id !== $craftsman->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $craftsman->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Profile deleted successfully.');
    }
}