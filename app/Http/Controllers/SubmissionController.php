<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function store(Request $request, Registration $registration)
    {
        // Ensure the registration belongs to the user
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        // Ensure registration is approved
        if ($registration->status !== 'approved') {
            return back()->with('error', 'Your registration must be verified before submitting work.');
        }

        $competition = $registration->competition;

        if ($competition->status !== 'ongoing') {
            return back()->with('error', 'Submissions are only allowed when the competition is ongoing.');
        }

        $rules = [];
        if (in_array($competition->submission_type, ['file', 'both'])) {
            // If it's "both" or "file" and the user uploaded a file
            if ($competition->submission_type === 'file' || $request->hasFile('submission_file')) {
                $rules['submission_file'] = ['required', 'file', 'max:5120']; // 5MB limit
            }
        }
        if (in_array($competition->submission_type, ['link', 'both'])) {
            // If it's "both" or "link" and the user provided a link
            if ($competition->submission_type === 'link' || $request->filled('submission_link')) {
                $rules['submission_link'] = ['required', 'url', 'max:255'];
            }
        }

        // If 'both' is selected, they must provide AT LEAST one
        if ($competition->submission_type === 'both' && !$request->hasFile('submission_file') && !$request->filled('submission_link')) {
            return back()->with('error', 'You must provide either a file or a link.');
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('submission_file')) {
            $registration->submission_file_path = $request->file('submission_file')->store('submissions', 'public');
        }

        if ($request->filled('submission_link')) {
            $registration->submission_link = $validated['submission_link'];
        }

        $registration->submitted_at = now();
        $registration->save();

        return back()->with('success', 'Your work has been submitted successfully!');
    }
}
