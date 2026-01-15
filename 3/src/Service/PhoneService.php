<?php
declare(strict_types=1);

namespace App\Service;

class PhoneService
{
    private array $phoneMap;

    public function __construct(string $configFilePath)
    {
        if (!file_exists($configFilePath)) {
            throw new \InvalidArgumentException("Phone number configuration file not found at: " . $configFilePath);
        }
        $this->phoneMap = require $configFilePath;
    }

    public function getPhoneByCity(string $city): ?string
    {
        return $this->phoneMap[$city] ?? null;
    }

    public function getPhoneMapForDebug(): array
    {
        return $this->phoneMap;
    }
}