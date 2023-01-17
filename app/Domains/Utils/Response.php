<?php

namespace App\Domains\Utils;

class Response
{
    public static function success(array $data): array
    {
        return [
            'data' => $data,
        ];
    }

    public static function fail(string $message, array $data = []): array
    {
        return [
            'message' => $message,
            'data' => $data,
        ];
    }
}
