<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Activity;
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
        $activity_select = $request->get('activity-select');
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
        $activities = Activity::all();

        return view('experiences.index', [
            'search' => $search,
            'activity_select' => $activity_select,
            'date_period' => $date_period,
            'date' => $date,
            'date2' => $date2,
            'experiences' => $experiences,
            'activities' => $activities
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('experiences.create', ['activities' => Activity::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'place' => 'required',
            'site_name' => 'required',
            'title' => 'required',
            'date' => 'required|date',
            'activity_id' => 'required|exists:activities,id',
            'description' => 'required',
            'distance' => 'required|integer',
            'priority' => 'required|integer',
        ], [
            'email.required' => "L'email est requis.",
            'email.email' => "L'email doit être une adresse email valide.",
            'first_name.required' => "Le prénom est requis.",
            'last_name.required' => "Le nom est requis.",
            'place.required' => "Le lieu est requis.",
            'site_name.required' => "Le nom du site est requis.",
            'title.required' => "Le titre est requis.",
            'date.required' => "La date est requise.",
            'date.date' => "La date doit être une date valide.",
            'activity_id.required' => "L'activité est requise.",
            'activity_id.exists' => "L'activité n'existe pas.",
            'description.required' => "La description est requise.",
            'distance.required' => "L'altitude est requise.",
            'distance.integer' => "L'altitude doit être un nombre entier.",
            'priority.required' => "La priorité est requise.",
            'priority.integer' => "La priorité doit être un nombre entier.",
        ]);



        $experience = new Experience();
        $experience->title = $request->input('title');
        $experience->site_name = $request->input('site_name');
        $experience->date = $request->input('date');
        $experience->activity_id = $request->input('activity_id');
        $experience->place = $request->input('place');
        $experience->description = $request->input('description');
        $experience->distance = $request->input('distance');
        $experience->priority = $request->input('priority');
        $experience->email = $request->input('email');
        $experience->first_name = $request->input('first_name');
        $experience->last_name = $request->input('last_name');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->getRealPath();
            $imageFile = file_get_contents($imagePath);
            $base64Image = base64_encode($imageFile);
            $experience->image = $base64Image;
        }
        $experience->save();

        return redirect()->route('experiences.create', ['activities' => Activity::all()])->with('success', 'Expérience ajoutée avec succès.');

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
