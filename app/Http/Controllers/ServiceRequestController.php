<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequestRequest;
use App\Http\Requests\UpdateServiceRequestRequest;
use App\Models\ServiceRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of service requests.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isCustomer()) {
            $requests = ServiceRequest::with(['craftsman', 'skill'])
                ->where('customer_id', $user->id)
                ->latest()
                ->paginate(10);
        } elseif ($user->isCraftsman()) {
            $requests = ServiceRequest::with(['customer', 'skill'])
                ->where('craftsman_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            $requests = ServiceRequest::with(['customer', 'craftsman', 'skill'])
                ->latest()
                ->paginate(10);
        }

        return Inertia::render('service-requests/index', [
            'requests' => $requests
        ]);
    }

    /**
     * Show the form for creating a new service request.
     */
    public function create()
    {
        $skills = Skill::active()->get();

        return Inertia::render('service-requests/create', [
            'skills' => $skills
        ]);
    }

    /**
     * Store a newly created service request.
     */
    public function store(StoreServiceRequestRequest $request)
    {
        $serviceRequest = ServiceRequest::create([
            'customer_id' => auth()->id(),
            'skill_id' => $request->skill_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'estimated_budget' => $request->estimated_budget,
            'preferred_date' => $request->preferred_date,
        ]);

        return redirect()->route('customer.service-requests.show', $serviceRequest)
            ->with('success', 'Service request created successfully.');
    }

    /**
     * Display the specified service request.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $user = auth()->user();
        if ($user->id !== $serviceRequest->customer_id && 
            $user->id !== $serviceRequest->craftsman_id && 
            !$user->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $serviceRequest->load(['customer', 'craftsman', 'skill', 'review']);

        return Inertia::render('service-requests/show', [
            'serviceRequest' => $serviceRequest
        ]);
    }

    /**
     * Show the form for editing the service request.
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        if (auth()->user()->id !== $serviceRequest->customer_id && !auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $skills = Skill::active()->get();

        return Inertia::render('service-requests/edit', [
            'serviceRequest' => $serviceRequest,
            'skills' => $skills
        ]);
    }

    /**
     * Update the service request.
     */
    public function update(UpdateServiceRequestRequest $request, ServiceRequest $serviceRequest)
    {
        if (auth()->user()->id !== $serviceRequest->customer_id && !auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $serviceRequest->update($request->validated());

        return redirect()->route('customer.service-requests.show', $serviceRequest)
            ->with('success', 'Service request updated successfully.');
    }

    /**
     * Remove the service request.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        if (auth()->user()->id !== $serviceRequest->customer_id && !auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }

        $serviceRequest->delete();

        return redirect()->route('customer.service-requests.index')
            ->with('success', 'Service request deleted successfully.');
    }
}