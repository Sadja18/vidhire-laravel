<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    public function dashboard()
    {
        // Only show interviews with at least one submitted submission
        $interviews = Interview::whereHas('submissions', function ($q) {
            $q->where('status', 'submitted');
        })->get();

        return view('reviewer.dashboard', compact('interviews'));
    }

    public function listCandidates(Interview $interview)
    {
        $candidates = \App\Models\User::whereHas('submissions', function ($q) use ($interview) {
            $q->where('interview_id', $interview->id)
                ->where('status', 'submitted');
        })->get();

        // Load draft/submitted status for current reviewer
        $reviews = \App\Models\Review::whereIn(
            'submission_id',
            \App\Models\Submission::where('interview_id', $interview->id)
                ->pluck('id')
        )
            ->where('reviewer_id', Auth::user()->id)
            ->get()
            ->groupBy('submission_id');

        // Map candidate_id => status
        $candidateStatuses = [];
        foreach ($candidates as $candidate) {
            $candidateSubmissions = $candidate->submissions()->where('interview_id', $interview->id)->pluck('id');

            $status = 'none';
            foreach ($candidateSubmissions as $submissionId) {
                if (isset($reviews[$submissionId])) {
                    foreach ($reviews[$submissionId] as $review) {
                        if ($review->status === 'submitted') {
                            $status = 'submitted';
                            break 2; // break both loops
                        } elseif ($review->status === 'draft') {
                            $status = 'draft';
                            // continue checking for submitted
                        }
                    }
                }
            }

            $candidateStatuses[$candidate->id] = $status;
        }

        return view('reviewer.candidate_list', compact('interview', 'candidates', 'candidateStatuses'));
    }


    public function reviewCandidate(Interview $interview, \App\Models\User $candidate)
    {
        $submissions = \App\Models\Submission::where('interview_id', $interview->id)
            ->where('candidate_id', $candidate->id)
            ->where('status', 'submitted')
            ->get();

        // Load existing draft reviews for this reviewer
        $reviews = \App\Models\Review::whereIn('submission_id', $submissions->pluck('id'))
            ->where('reviewer_id', Auth::user()->id)
            ->get()
            ->keyBy('submission_id');

        return view('reviewer.review_candidate', compact('interview', 'candidate', 'submissions', 'reviews'));
    }

    public function saveReviewCandidate(Request $request, Interview $interview, \App\Models\User $candidate)
    {
        $request->validate([
            'score.*' => 'required|integer|min:1|max:5',
            'comment.*' => 'nullable|string|max:500',
        ]);

        foreach ($request->input('score') as $submissionId => $score) {
            $reviewer_id = Auth::user()->id;
            $review = \App\Models\Review::updateOrCreate(
                [
                    'submission_id' => $submissionId,
                    'reviewer_id' => $reviewer_id,
                ],
                [
                    'score' => $score,
                    'comment' => $request->input('comment')[$submissionId] ?? null,
                    'status' => $request->input('status') === 'submit' ? 'submitted' : 'draft',
                ]
            );

            if ($review->status === 'submitted') {
                $submission = $review->submission;
                $submission->update([
                    'score' => $score,
                    'comment' => $review->comment,
                ]);
            }
        }

        // $msg = $request->input('status') === 'submit' ? 'Review submitted.' : 'Draft saved.';
        if ($request->input('status') === 'submit') {
            return redirect()->route('reviewer.interview.candidate.preview', [$interview->id, $candidate->id])
                ->with('success', 'Review submitted.');
        } else {
            return redirect()->route('reviewer.interview.candidates', $interview->id)
                ->with('success', 'Draft saved.');
        }
    }

    public function previewCandidateReview(Interview $interview, \App\Models\User $candidate)
    {
        $submissions = \App\Models\Submission::where('interview_id', $interview->id)
            ->where('candidate_id', $candidate->id)
            ->get();

        // Only show if reviews exist and are submitted
        $reviews = \App\Models\Review::whereIn('submission_id', $submissions->pluck('id'))
            ->where('reviewer_id', Auth::user()->id)
            ->where('status', 'submitted')
            ->get()
            ->keyBy('submission_id');

        if ($reviews->isEmpty()) {
            return redirect()->route('reviewer.interview.candidates', $interview->id)
                ->with('error', 'No final review submitted yet.');
        }

        return view('reviewer.preview_candidate', compact('interview', 'candidate', 'submissions', 'reviews'));
    }
}
