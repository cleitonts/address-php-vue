<?php

namespace App\Controller;

use App\Kernel\Router\RouteAttribute;
use App\Repository\AddressRepository;

class City
{
    public function __construct(private AddressRepository $addressRepository)
    {
    }

    #[RouteAttribute('GET', '/city')]
    public function home(): string
    {
        return json_encode($this->addressRepository->getCity());
    }
}