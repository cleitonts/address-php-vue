<?php

namespace App\Entity;

class City
{
    public function __construct(
        public int $id,
        public string $name
    ) {}
}