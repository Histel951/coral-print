<?php

namespace App\Services\Calculator\Count\Algorithms;

use App\Models\WorkAdditional;
use App\Services\Calculator\Count\Util\Exceptions\WorkAdditionalException;
use Illuminate\Support\Facades\Cache;

trait WorkAdditionalSetter
{
    /**
     * Устанавливает доп работу для алгоритма подсчёта калькулятора
     * @param int $addJobId
     * @param int $times
     * @param float $coefficient
     * @throws WorkAdditionalException
     */
    public function setWorkAdditional(int $addJobId, int $times = 1, float $coefficient = 1): void
    {
        for ($iterator = 0; $iterator < $times; $iterator++) {
            $cacheKey = cache_key('calculator:master:add_job_id', [
                'add_job_id' => $addJobId,
            ]);

            $job = Cache::tags(['calculatorMaster', 'setAddJob', 'work_additional'])->remember(
                $cacheKey,
                now()->addHours(24),
                fn () => WorkAdditional::with(['prices', 'formula'])->find($addJobId),
            );

            if (!empty($job)) {
                $jobArr = $job->toArray();

                $jobArr['coefficient'] = $coefficient;
                $this->calculable['add_jobs'][] = $jobArr;
            } else {
                throw new WorkAdditionalException('Not founded additional job with id ' . $addJobId);
            }
        }
    }
}
