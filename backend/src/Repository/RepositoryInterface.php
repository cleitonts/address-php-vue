<?php

namespace App\Repository;

interface RepositoryInterface
{
    function getTable(): string;
    function getEntity(): string;
}