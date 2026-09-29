<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Registration;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompetitionRegistrationController extends Controller
{
    public function create(Competition $competition)
    {
        // Check if inactive
        if ($competition->status === 'inactive') {
            return redirect()->route('dashboard')->with('error', 'This competition is currently inactive and no longer accepts registrations.');
        }

        // Check if registration is open
        if ($competition->status !== 'registration_open') {
            return redirect()->route('dashboard')->with('error', 'Registration for this competition is currently closed.');
        }

        // Check deadline
        if ($competition->registration_close_at && now()->isAfter($competition->registration_close_at)) {
            return redirect()->route('dashboard')->with('error', 'The registration deadline has passed.');
        }

        // Check if already registered with an active status
        if (Registration::where('user_id', Auth::id())
            ->where('competition_id', $competition->id)
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->exists()) {
            return redirect()->route('dashboard')->with('error', 'You already have an active registration for this competition.');
        }

        return view('register-competition', compact('competition'));
    }

    public function store(Request $request, Competition $competition)
    {
        // Check if inactive
        if ($competition->status === 'inactive') {
            return back()->withErrors(['competition' => 'This competition is currently inactive and no longer accepts registrations.']);
        }

        // Check if registration is open
        if ($competition->status !== 'registration_open') {
            return back()->withErrors(['competition' => 'Registration is closed.']);
        }

        if (Registration::where('user_id', Auth::id())
            ->where('competition_id', $competition->id)
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->exists()) {
            return back()->withErrors(['competition' => 'You already have an active registration for this competition.']);
        }

        // Base Validation
        $rules = [
            'registration_mode' => ['required', Rule::in(['solo', 'team'])],
            'proof_of_payment' => $competition->requiresPayment()
                ? ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048']
                : ['nullable'],
        ];

        // Mode specific validation
        if ($request->registration_mode === 'team') {
            if ($competition->registration_type === 'individual') {
                return back()->withErrors(['registration_mode' => 'This competition is for individuals only.']);
            }
            
            $rules['team_name'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('registrations')->where(function ($query) use ($competition) {
                    return $query->where('competition_id', $competition->id);
                })
            ];

            // Validate team members
            $rules['members'] = ['array', 'max:' . ($competition->max_team_members - 1)];
            $rules['members.*.name'] = ['required', 'string', 'max:255'];
            $rules['members.*.nim'] = ['required', 'string', 'max:50'];
        } else {
            if ($competition->registration_type === 'team') {
                return back()->withErrors(['registration_mode' => 'This competition requires team registration.']);
            }
        }

        $validated = $request->validate($rules);

        // Upload Proof (only for paid competitions with an uploaded file)
        $path = null;
        if ($competition->requiresPayment() && $request->hasFile('proof_of_payment')) {
            $path = $request->file('proof_of_payment')->store('payment-proofs', 'public');
        }

        // Team name for solo
        $teamName = $request->registration_mode === 'team' ? $validated['team_name'] : Auth::user()->name;

        // Create Registration
        $registration = Registration::create([
            'competition_id' => $competition->id,
            'user_id' => Auth::id(),
            'registration_mode' => $validated['registration_mode'],
            'team_name' => $teamName,
            'proof_of_payment' => $path,
            'status' => 'pending',
        ]);

        // Add team members if applicable
        if ($request->registration_mode === 'team' && isset($validated['members'])) {
            foreach ($validated['members'] as $member) {
                TeamMember::create([
                    'registration_id' => $registration->id,
                    'name' => $member['name'],
                    'nim' => $member['nim'],
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Registration submitted successfully! Waiting for verification.');
    }
}

