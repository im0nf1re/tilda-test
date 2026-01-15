<?php
// src/Service/GeoIpService.php

declare(strict_types=1);

namespace App\Service;

class GeoIpService
{
    private const API_URL = 'http://ip-api.com/json/';

    public function getCityByIp(string $ip): ?string
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return null;
        }

        $url = self::API_URL . $ip . '?lang=ru&fields=status,message,city';

        $context = stream_context_create([
            'http' => [
                'timeout' => 2,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        if (empty($data) || $data['status'] !== 'success' || empty($data['city'])) {
            return null;
        }

        return $data['city'];
    }
}
