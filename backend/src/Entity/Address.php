<?php

namespace App\Entity;

class Address
{
    public function __construct(
        public string $street,
        public int $city,
        public string $zip,
        public string $email,
        public string $name,
        public string $firstName,
        public ?int $id = null
    ) {}
}