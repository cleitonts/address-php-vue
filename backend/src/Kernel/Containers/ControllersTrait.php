<?php

namespace App\Kernel\Containers;

trait ControllersTrait
{
    private array $controllers;

    public function loadControllers($controllersDirectory): void
    {
        $controllers = [];
        foreach (glob($controllersDirectory . '/*.php') as $file) {
            $className = 'App\Controller\\' . pathinfo($file, PATHINFO_FILENAME);
            if (class_exists($className)) {
                $controllers[] = $className;
            }
        }
        $this->controllers = $controllers;
    }

    public function getControllers(): array
    {
        return $this->controllers;
    }
}