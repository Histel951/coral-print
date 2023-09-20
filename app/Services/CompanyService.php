<?php

namespace App\Services;

use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CompanyService
{
    public function getOrCreate(string $name, ?string $inn): Builder|Model|null
    {
        if (!$this->isExist($name)) {
            try {
                return $this->create($name, $inn);
            } catch (Exception $e) {
                Log::error($e->getMessage(), $e->getTrace());
            }
        }

        return Company::query()
            ->where('name', $name)
            ->first();
    }

    private function isExist(string $name): bool
    {
        return (bool) Company::query()
            ->where('name', $name)
            ->first();
    }

    /**
     * @throws Exception
     */
    private function create(string $name, ?string $inn): Company
    {
        if (strlen($inn) !== 10) {
            throw new Exception('Wrong INN length');
        }

        return Company::create([
            'name' => $name,
            'inn' => $inn,
        ]);
    }
}
