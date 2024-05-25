<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Experience;
use App\Models\Activity;
use App\Models\Edit;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DateTime;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $search = $request->get('search');
            $activity_select = $request->get('activity-select');
            $date = $request->get('date');
            $date2 = $request->get('date2');
            $formatted_date = new DateTime($date);
            $formatted_date2 = new DateTime($date2);
            $date_period = $request->get('date-period');

            $query = Experience::query()->where('published_at', null);


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


            return view('users.index', [
                'search' => $search,
                'activity_select' => $activity_select,
                'date_period' => $date_period,
                'date' => $date,
                'date2' => $date2,
                'experiences' => $experiences,
                'activities' => $activities,
            ]);
        } else {
            return redirect('login');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($token)
    {
        // Vérifier si le token existe
        // $invitation = Invitation::where('token', $token)->firstOrFail();

        // Passer le token à la vue
        return view('users.create', ['token' => $token]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pseudo' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirmed_password' => 'required|same:password',
        ], [
            'pseudo.required' => 'Le pseudo est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'confirmed_password.required' => 'La confirmation du mot de passe est obligatoire',
            'confirmed_password.same' => 'Les mots de passe ne correspondent pas',
        ]);

        $user = new User();
        $user->pseudo = $request->input('pseudo');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->route('experiences.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    // public function storeToken(Request $request)
    // {
    //     if (Auth::check()) {
    //         // Obtenir l'utilisateur connecté
    //         $user = Auth::user();

    //         $token = Str::random(16);

    //         while (Invitation::where('token', $token)->exists()) {
    //             $token = Str::random(16);
    //         }

    //         Invitation::create([
    //             'username' => $user->username,
    //             'token' => $token,
    //         ]);

    //         $url = route('users.create', ['token' => $token]);

    //         return response()->json(['success' => 'Token created successfully']);
    //     } else {
    //         return response()->json(['error' => 'User not logged in'], 401);
    //     }
    // }


}
