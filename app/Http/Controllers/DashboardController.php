<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\Competition;
use App\Models\Announcement;
use App\Enums\UserRole;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Strictly protect participant dashboard: redirect any non-participant or backoffice user
        if (!$user || $user->isBackofficeUser() || !$user->isParticipant()) {
            return redirect('/admin');
        }
        
        // Fetch ALL registrations for the user ordered by created_at DESC
        $allRegistrations = Registration::with(['competition', 'ticket', 'members'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $latestRegistrations = collect();
        $registrationHistory = collect();
        
        foreach ($allRegistrations->groupBy('competition_id') as $compId => $regs) {
            $latestRegistrations->push($regs->first());
            if ($regs->count() > 1) {
                $registrationHistory = $registrationHistory->merge($regs->slice(1));
            }
        }
            
        $registeredCompIds = $latestRegistrations->pluck('competition_id')->toArray();
        
        // Fetch ALL open competitions (the view will adapt the buttons based on registration state)
        $availableCompetitions = Competition::where('status', 'registration_open')->get();
        
        // Fetch relevant announcements
        $announcementQuery = Announcement::whereNotNull('published_at')
            ->where('published_at', '<=', now());

        if ($latestRegistrations->count() > 0) {
            $announcementQuery->where(function($q) use ($registeredCompIds) {
                $q->whereNull('competition_id')
                  ->orWhereIn('competition_id', $registeredCompIds);
            });
        } else {
            $announcementQuery->whereNull('competition_id');
        }

        $announcements = $announcementQuery->orderBy('published_at', 'desc')->take(5)->get();

        return view('dashboard', compact('latestRegistrations', 'registrationHistory', 'availableCompetitions', 'announcements'));
    }
}
