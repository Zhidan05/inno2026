<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{
    /**
     * Display the specified competition details to the participant.
     */
    public function show(Competition $competition)
    {
        $user = Auth::user();
        
        $latestRegistration = null;
        
        if ($user) {
            $latestRegistration = Registration::where('user_id', $user->id)
                ->where('competition_id', $competition->id)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        return view('competition-details', compact('competition', 'latestRegistration'));
    }
}
