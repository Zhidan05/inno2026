<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\Competition;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirect users with admin panel access directly to the admin panel
        if ($user->hasRole(['super_admin', 'moderator', 'judge'])) {
            return redirect('/admin');
        }
        
        // Fetch ALL registrations for the user
        $registrations = Registration::with(['competition', 'ticket', 'members'])
            ->where('user_id', $user->id)
            ->get();
            
        // Fetch open competitions that the user hasn't registered for
        $registeredCompIds = $registrations->pluck('competition_id')->toArray();
        $availableCompetitions = Competition::where('status', 'registration_open')
            ->whereNotIn('id', $registeredCompIds)
            ->get();
        
        // Fetch relevant announcements
        // If user has registrations, fetch global + specific
        // If none, fetch only global
        $announcementQuery = Announcement::whereNotNull('published_at')
            ->where('published_at', '<=', now());

        if ($registrations->count() > 0) {
            $announcementQuery->where(function($q) use ($registeredCompIds) {
                $q->whereNull('competition_id')
                  ->orWhereIn('competition_id', $registeredCompIds);
            });
        } else {
            $announcementQuery->whereNull('competition_id');
        }

        $announcements = $announcementQuery->orderBy('published_at', 'desc')->take(5)->get();

        return view('dashboard', compact('registrations', 'availableCompetitions', 'announcements'));
    }
}
