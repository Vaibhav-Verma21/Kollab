<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\PeerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeerReviewController extends Controller
{
    public function index()
    {
        // Find assigned reviews for the current user
        $pendingReviews = PeerReview::where('reviewer_id', Auth::id())
                                    ->where('is_completed', false)
                                    ->get();

        // Also fetch completed reviews
        $completedReviews = PeerReview::where('reviewer_id', Auth::id())
                                      ->where('is_completed', true)
                                      ->get();

        return view('peer_reviews.index', compact('pendingReviews', 'completedReviews'));
    }

    public function show($reviewId)
    {
        $review = PeerReview::where('id', $reviewId)
                            ->where('reviewer_id', Auth::id())
                            ->firstOrFail();

        $submission = AssignmentSubmission::findOrFail($review->submission_id);
        $assignment = Assignment::findOrFail($submission->assignment_id);

        return view('peer_reviews.show', compact('review', 'submission', 'assignment'));
    }

    public function submit(Request $request, $reviewId)
    {
        $review = PeerReview::where('id', $reviewId)
                            ->where('reviewer_id', Auth::id())
                            ->firstOrFail();

        $submission = AssignmentSubmission::findOrFail($review->submission_id);
        $assignment = Assignment::findOrFail($submission->assignment_id);

        $rubricScores = $request->input('scores', []);
        $totalScore = 0;
        
        foreach ($assignment->rubric as $index => $criteria) {
            $score = isset($rubricScores[$index]) ? (int)$rubricScores[$index] : 0;
            $totalScore += ($score * ($criteria['weight'] / 100));
        }

        $review->update([
            'rubric_scores' => $rubricScores,
            'comments' => $request->input('comments'),
            'total_score' => $totalScore,
            'is_completed' => true,
        ]);

        $completedReviews = PeerReview::where('submission_id', $submission->id)
                                      ->where('is_completed', true);
        
        $completedCount = $completedReviews->count();
        $averageScore = $completedReviews->avg('total_score');

        $updates = [];
        if ($completedCount >= 10) {
            $updates['status'] = 'reviewed';
        }

        // Only update the grade if an admin hasn't overridden it
        if (!$submission->graded_by && $averageScore !== null) {
            $updates['grade'] = round($averageScore, 2);
        }

        if (!empty($updates)) {
            $submission->update($updates);
        }

        return redirect()->route('peer_reviews.index')->with('success', 'Peer review submitted successfully. Thank you!');
    }
}
