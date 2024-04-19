<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Activity;
use App\Models\Edit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $query = Experience::query()->whereNotNull('published_at');



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
        return view('experiences.create', ['experience' => null, 'activities' => Activity::all()]);
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
            $imagePath = $request->file('image')->store('images', 'public');
            $experience->image = $imagePath;
        }
        $experience->save();

        return redirect()->route('experiences.create', ['activities' => Activity::all()])->with('success', 'Expérience ajoutée avec succès.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        if (Auth::check()) {

        $edits = Edit::where('experience_id', $experience->id)
                ->orderBy('updated_at', 'desc')
                ->get();
            return view('experiences.show', ['experience' => $experience, 'edits' => $edits]);
        } else {
            return view('experiences.show', ['experience' => $experience, 'edits' => null]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        //
        if (Auth::check()) {
            return view('experiences.create', ['experience' => $experience, 'activities' => Activity::all()]);
        } else {
            return redirect('login');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {
        //
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
            $imagePath = $request->file('image')->store('images', 'public');
            $experience->image = $imagePath;
        }
    
        $edit = Edit::where('experience_id', $experience->id)
        ->where('user_id', Auth::id())
        ->first();

        if (!$edit) {
            $edit = new Edit();
        }
        $edit->experience_id = $experience->id;
        $edit->user_id = Auth::id();
        $edit->save();

        $experience->save();
        

        return redirect()->route('experiences.show', ['experience' => $experience])->with('success', 'Expérience modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        //
    }
}
