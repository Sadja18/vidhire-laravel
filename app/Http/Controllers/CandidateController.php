<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CandidateLink;

class CandidateController extends Controller
{
    public function dashboard()
    {
        $candidate = Auth::user();

        // Get all interviews assigned to this candidate
        $links = CandidateLink::with('interview')
            ->where('candidate_id', $candidate->id)
            ->latest()
            ->get();

        return view('candidate.dashboard', compact('links'));
    }

    // public function showInterview($token)
    // {
    //     $link = \App\Models\CandidateLink::with('interview.questions')
    //         ->where('token', $token)
    //         ->firstOrFail();


    //     return view('candidate.interview', compact('link'));
    // }
    public function showInterview($token)
    {
        $link = \App\Models\CandidateLink::with('interview.questions')
            ->where('token', $token)
            ->firstOrFail();

        $submissions = \App\Models\Submission::where('candidate_id', $link->candidate_id)
            ->where('interview_id', $link->interview_id)
            ->get()
            ->keyBy('question_id'); // easier access by question id

        return view('candidate.interview', compact('link', 'submissions'));
    }


    // public function submitAnswers(Request $request, $token)
    // {
    //     $link = \App\Models\CandidateLink::with('interview.questions')
    //         ->where('token', $token)
    //         ->firstOrFail();

    //     foreach ($link->interview->questions as $question) {
    //         \App\Models\Submission::create([
    //             'candidate_id' => $link->candidate_id,
    //             'interview_id' => $link->interview_id,
    //             'question_id' => $question->id,
    //             'video_url' => $request->input('question_' . $question->id),
    //         ]);
    //     }

    //     return redirect()->route('candidate.dashboard')->with('success', 'Answers submitted successfully.');
    // }
    public function submitAnswers(Request $request, $token)
    {
        $link = \App\Models\CandidateLink::with('interview.questions')
            ->where('token', $token)
            ->firstOrFail();

        $status = $request->input('status') === 'submit' ? 'submitted' : 'draft';
        $submitted_at = $status === 'submitted' ? now() : null;

        foreach ($link->interview->questions as $question) {
            \App\Models\Submission::updateOrCreate(
                [
                    'candidate_id' => $link->candidate_id,
                    'interview_id' => $link->interview_id,
                    'question_id' => $question->id,
                ],
                [
                    'video_url' => $request->input('question_' . $question->id),
                    'status' => $status,
                    'submitted_at' => $submitted_at,
                ]
            );
        }

        $msg = $status === 'submitted' ? 'Interview submitted successfully.' : 'Draft saved successfully.';
        return redirect()->route('candidate.dashboard')->with('success', $msg);
    }

    public function previewInterview($token)
    {
        $link = \App\Models\CandidateLink::with('interview.questions')->where('token', $token)->firstOrFail();

        // Only allow if interview is submitted
        $submissions = \App\Models\Submission::where('candidate_id', $link->candidate_id)
            ->where('interview_id', $link->interview_id)
            ->where('status', 'submitted')
            ->get()
            ->keyBy('question_id');

        if ($submissions->isEmpty()) {
            return redirect()->route('candidate.dashboard')->with('error', 'Interview has not been submitted yet.');
        }

        return view('candidate.preview', compact('link', 'submissions'));
    }
}
