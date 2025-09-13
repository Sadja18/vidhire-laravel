<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Interview;
use App\Models\Question;

use App\Models\CandidateLink;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        // $interviews = $admin->interviews()->latest()->get(); // admin-created interviews
        // return view('admin.dashboard', compact('interviews'));
        $interviews = $admin->interviews()
            ->withCount('candidateLinks') // counts links per interview
            ->latest()
            ->get();

        $totalCandidates = \App\Models\User::where('role', 'candidate')->count();

        return view('admin.dashboard', compact('interviews', 'totalCandidates'));
    }

    public function create()
    {
        return view('admin.create_interview'); // create this Blade
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions.*' => 'required|string|max:500',
        ]);

        $interview = Interview::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->questions as $q) {
            Question::create([
                'interview_id' => $interview->id,
                'text' => $q,
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Interview created.');
    }

    public function edit(Interview $interview)
    {
        return view('admin.edit_interview', compact('interview'));
    }

    public function update(Request $request, Interview $interview)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions.*' => 'required|string|max:500',
        ]);

        $interview->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Update existing questions (assume 3 questions)
        foreach ($interview->questions as $index => $question) {
            $question->update([
                'text' => $request->questions[$index] ?? $question->text,
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Interview updated.');
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Interview deleted.');
    }

    public function showGenerateLinkForm(Interview $interview)
    {
        // Optionally, pass a list of candidates to select
        $candidates = \App\Models\User::where('role', 'candidate')->get();
        return view('admin.generate_link', compact('interview', 'candidates'));
    }

    public function storeCandidateLink(Request $request, Interview $interview)
    {
        $request->validate([
            'candidate_id' => 'required|exists:users,id',
        ]);

        $token = Str::uuid()->toString(); // generate unique token

        CandidateLink::create([
            'interview_id' => $interview->id,
            'candidate_id' => $request->candidate_id,
            'token' => $token,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Candidate link generated: ' . $token);
    }

    // public function candidateLinksDashboard()
    // {
    //     $links = \App\Models\CandidateLink::with(['interview', 'candidate'])->latest()->get();
    //     return view('admin.candidate_links_dashboard', compact('links'));
    // }
    public function candidateLinksDashboard($interviewId)
    {
        $links = \App\Models\CandidateLink::with(['interview', 'candidate'])
            ->where('interview_id', $interviewId)
            ->latest()
            ->get();

        return view('admin.candidate_links_dashboard', compact('links'));
    }


    public function destroyCandidateLink(\App\Models\CandidateLink $link)
    {
        $interviewId = $link->interview_id; // or $link->interview->id if it’s a relation
        $link->delete();

        return redirect()
            ->route('admin.candidate_links.dashboard', ['interview' => $interviewId])
            ->with('success', 'Candidate link deleted.');
    }
}
