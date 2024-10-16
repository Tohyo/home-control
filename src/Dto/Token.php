<?php

namespace App\Dto;

class Token
{
    public function __construct(
        public readonly string $accessToken,
        public readonly string $refreshToken
    ) {
    }
}
