<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

final class DepartmentService
{
    /**
     * @return array
     */
    public function getMetroStations(): array
    {
        $response = Http::get('https://api.superjob.ru/2.0/suggest/town/4/metro/all');
        $stationsArr = json_decode($response->body(), true);

        return array_column($stationsArr['objects'], 'title');
    }
}
