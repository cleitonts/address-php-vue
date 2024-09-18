<?php

namespace App\Kernel\Http;

use App\Kernel\AppException;

class Request
{
    private readonly array $data;

    public function __construct()
    {
        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
        parse_str($parsedUrl['query'] ?? '', $data);
        $rawData = file_get_contents('php://input');

        if (!$rawData) {
            $this->data = $data;
            return;
        }

        $this->data = array_merge(json_decode($rawData, true), $data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AppException('Invalid data');
        }
    }

    public function get(string $key, bool $nullable = false): mixed
    {
        if (!$nullable && empty($this->data[$key])) {
            throw new AppException("Invalid data: $key");
        }
        return $this->data[$key] ?? null;
    }
}