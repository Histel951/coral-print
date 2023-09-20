<?php

namespace App\Http\Controllers;

use App\Services\ContentService;
use App\Services\ReviewService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function reviews(int $contentId, ReviewService $reviewService, ContentService $contentService): View
    {
        if (!($content = $contentService->getContentById($contentId))) {
            abort(404);
        }

        $reviews = $reviewService->getApprovedReviewsByCalculatorTypeId($content->calc_type);

        return view('reviews', [
            'reviews' => $reviews,
            'content' => $content,
            'reviewTitle' => $content->calculatorType?->review_title,
            'reviewAvgRate' => $reviewService->getAvgRate($content->calculatorType?->id),
            'calculatorTypeId' => $content->calculatorType?->id,
        ]);
    }

    public function reviewsAll(ReviewService $reviewService): View
    {
        return view('reviews', [
            'reviews' => $reviewService->getApprovedReviews(),
            'reviewTitle' => ' всей продукции',
            'reviewAvgRate' => $reviewService->getAvgRate(),
        ]);
    }

    public function send(Request $request, ReviewService $reviewService)
    {
        if (!$reviewService->checkEmail($request->toArray())) {
            return response()->json([
                'success' => false,
                'field' => 'email',
                'error' => 'Эта почта уже использовалась',
            ]);
        }

        if (!$request->input('file_id')) {
            return response()->json([
                'success' => false,
                'field' => 'avatar',
                'error' => 'Это поле обязательно для заполнения',
            ]);
        }

        return response()->json(['success' => $reviewService->send($request->all())]);
    }
}
