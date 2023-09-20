<?php

namespace App\Services;

use App\Models\FileUpload;
use App\Models\Review;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class ReviewService
{
    public const STATUS_NEW = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_REJECTED = 3;

    protected SendMailService $sendMailService;

    /**
     * @param SendMailService $sendMailService
     */
    public function __construct(SendMailService $sendMailService)
    {
        $this->sendMailService = $sendMailService;
    }

    /**
     * @param int $contentId
     * @param int $limit
     * @return mixed
     */
    public function getApprovedReviewsByCalculatorTypeId(?int $calculatorTypeId, int $limit = 0)
    {
        if (!$calculatorTypeId) {
            return new Collection();
        }

        $query = Review::with('avatar')
            ->orderBy('created_at', 'DESC')
            ->where('status', ReviewService::STATUS_APPROVED)
            ->where('calculator_type_id', $calculatorTypeId);
        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * @return iterable
     */
    public function getApprovedReviews(): iterable
    {
        return Review::with('avatar')
            ->orderBy('created_at', 'DESC')
            ->where('status', ReviewService::STATUS_APPROVED)
            ->get();
    }

    /**
     * @param array $request
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * Обработка данных формы отзывов (из модалки)
     */
    public function send(array $request): bool
    {
        try {
            DB::beginTransaction();

            $model = new Review($request);
            $model->save();

            if ($file = FileUpload::find(request()->get('file_id'))) {
                $file->fileable_type = Review::class;
                $file->fileable_id = $model->id;
                $file->is_temp = false;
                $file->save();
            }

            DB::commit();

            return true;
        } catch (Exception) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param array $request
     * @return bool
     */
    public function checkEmail(array $request): bool
    {
        return !Review::where('email', $request['email'])
            ->where('calculator_type_id', $request['calculator_type_id'])
            ->count();
    }

    /**
     * @param int $status
     * @return string
     */
    public function getStatusText(int $status): string
    {
        $statuses = [
            self::STATUS_NEW => 'Новый',
            self::STATUS_APPROVED => 'Одобрен',
            self::STATUS_REJECTED => 'Отклонен',
        ];

        return $statuses[$status] ?? $statuses[self::STATUS_NEW];
    }

    public function getStatuses(): array
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_APPROVED => 'Одобрен',
            self::STATUS_REJECTED => 'Отклонен',
        ];
    }

    /**
     * @param $categoryId
     * @return float
     */
    public function getAvgRate($categoryId = null): float
    {
        $query = Review::select(DB::raw('avg(rate) as avg'))->where('status', self::STATUS_APPROVED);
        if ($categoryId) {
            $query->where('calculator_type_id', $categoryId);
        }

        return round($query->get()->first()->avg, 2);
    }
}
