<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use DateTime;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->get('search');
        $activity_select = $request->get('activity');
        $date = $request->get('date');
        $date2 = $request->get('date2');
        $formatted_date = new DateTime($date);
        $formatted_date2 = new DateTime($date2);
        $date_period = $request->get('date-period');

        $query = Experience::query();

        if ($activity_select) {
            $query->whereHas('activity', function ($query) use ($activity_select) {
                $query->where('name', $activity_select);
            });
        }
        
        if ($date_period == 'before' && $date != null) {
            $query->where('date', '<', $formatted_date);
        } elseif ($date_period == 'after' && $date != null) {
            $query->where('date', '>', $formatted_date);
        } elseif ($date_period == 'between' && $date != null && $date2 != null) {
            $query->whereBetween('date', [$formatted_date, $formatted_date2]);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('site_name', 'like', "%{$search}%");
            });
        }

        $experiences = $query->orderBy('published_at', 'desc')->get();
        $activities = Experience::with('activity')->get()->pluck('activity.name')->unique();

        return view('experiences.index', compact('experiences', 'activities'), [
            'search' => $search,
            'activity_select' => $activity_select,
            'date_period' => $date_period,
            'date' => $date,
            'date2' => $date2,
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        return view('experiences.show', ['experience' => $experience]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        //
    }
}
