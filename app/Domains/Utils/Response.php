<?php

namespace App\Domains\Utils;

class Response
{
    public static function success(array $data): array
    {
        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public static function fail(string $message, array $data = []): array
    {
        return [
            'success' => false,
            'message' => $message,
            'data' => $data,
        ];
    }
}
