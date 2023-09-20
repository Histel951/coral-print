<?php

namespace App\Http\Controllers;

use App\Models\Advantages;
use App\Models\Calculator;
use App\Models\Content;
use App\Services\Calculator\CalculatorService;
use App\Services\ContentService;
use App\Services\GalleryService;
use App\Services\ReviewService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly ReviewService $reviewService,
        private readonly GalleryService $galleryService
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function index(Request $request): Factory|View|Application
    {
        $content = $this->contentService->getContentByUrl($request->path());

        return $content->is_production ? $this->production($content) : $this->page($content);
    }

    /**
     * @throws BindingResolutionException
     */
    private function production(Content $content)
    {
        $calculatorType = $content->calculators->first()?->calculatorType()->first();
        $reviews = $this->reviewService->getApprovedReviewsByCalculatorTypeId($calculatorType?->id);

        $calculatorService = app()->make(CalculatorService::class, [
            'calculator' => $content->default_calculator_id ? Calculator::find(
                $content->default_calculator_id
            ) : $content->calculators->first()
        ]);

        return view(
            'product',
            [
                'template' => $this->contentService->addContentByDirective($content)->pageTemplate,
                'params' => [
                    'types' => $calculatorType ? json_encode($calculatorService->types($calculatorType)) : '',
                    'content' => $content,
                    'advantages' => Advantages::query()->where('calculator_type_id', $calculatorType?->id)->get(),
                    'reviews' => $reviews->slice(0, 3),
                    'reviewTitle' => $calculatorType?->review_title,
                    'reviewsCount' => $reviews->count(),
                    'isEmptyFolder' => $this->contentService->isEmptyFolder($content->content_id),
                    'breadCrumbsArr' => $this->contentService->getBreadcrumbsArr($content->content_id),
                    'reviewAvgRate' => $this->reviewService->getAvgRate($calculatorType?->id),
                    'calculatorTypeId' => $calculatorType?->id,
                    'currentChildItems' => $this->contentService->getChildItems($content->content_id),
                    'files' => $content->default_calculator_id
                        ? $this->galleryService->getVisibleGalleriesItems(
                            $calculatorType->galleries->filter(
                                fn ($gallery) => $gallery->calculator_id == $content->default_calculator_id
                            )->first()?->categories->first()
                        )
                            ->pluck('files')->collapse()
                        : $this->galleryService->getRandomGalleryItems($calculatorType?->id),
                    'default_calculator_id' => $content->default_calculator_id ?? 0,
                    'calcs' => $this->galleryService->getGalleriesCalculatorIds(
                        $calculatorType?->galleryCategories
                    ),
                ],
            ]
        );
    }

    private function page(Content $content)
    {
        return view('product', [
            'template' => $this->contentService->addContentByDirective($content)->pageTemplate,
            'params' => [
                'mainChildItems' => $this->contentService->getChildItems(ContentService::PARENT_ID),
            ],
        ]);
    }
}
