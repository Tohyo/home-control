<?php

namespace App\Dto;

final class Shutter
{
    public function __construct(
        public int $id,
        public string $label,
        public int $siteId
    ) {
    }
}
