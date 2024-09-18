<?php

namespace App\Kernel\Containers;

use App\Kernel\EnvLoader;

class Container
{
    use ControllersTrait;
    use ServicesTrait;

    private EnvLoader $envLoader;

    public function boot(
        $controllersDirectory,
        $envDirectory
    ): void
    {
        $this->loadControllers($controllersDirectory);
        $this->envLoader = new EnvLoader();
        $this->envLoader->load($envDirectory);
    }

    public function getEnv($key)
    {
        return $this->envLoader->get($key);
    }
}