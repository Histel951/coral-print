<?php

namespace App\Services;

use Dadata\DadataClient;

class DadataSuggestService
{
    private const REGION_CODES = [77, 50];

    public function __construct(private DadataClient $client)
    {
    }

    public function address(array $data): array
    {
        $suggest = $this->client->suggest('address', $data['query'], $data['limit'] ?? 4, [
            'locations' => [
                'region' => $data['region'],
            ],
            'restrict_value' => $data['restricted'] ?? false,
        ]);

        foreach ($suggest as $key => $value) {
            unset($suggest[$key]['data']);
        }

        return $suggest;
    }

    public function company(array $data): array
    {
        $suggest = $this->client->suggest('party', $data['query'], $data['limit'] ?? 4, [
            'locations' => array_map(function ($code) {
                return ['kladr_id' => $code];
            }, self::REGION_CODES),
            'status' => ['ACTIVE'],
        ]);

        foreach ($suggest as $key => $value) {
            $suggest[$key]['inn'] = $value['data']['inn'];

            unset($suggest[$key]['data']);
            unset($suggest[$key]['unrestricted_value']);
        }

        return $suggest;
    }

    public function name(array $data): array
    {
        $suggest = $this->client->suggest('fio', $data['query'], $data['limit'] ?? 4);

        foreach ($suggest as $key => $value) {
            unset($suggest[$key]['unrestricted_value']);
            unset($suggest[$key]['data']);
        }

        return $suggest;
    }
}
