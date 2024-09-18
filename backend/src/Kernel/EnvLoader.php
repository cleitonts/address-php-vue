<?php

namespace App\Kernel;

class EnvLoader
{
    private array $env = [];

    public function load($file): void
    {
        if (file_exists($file)) {
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (str_contains($line, '=')) {
                    list($key, $value) = explode('=', $line, 2);
                    $this->env[strtoupper(trim($key))] = trim($value);
                }
            }
        }
    }

    public function get($key)
    {
        return $this->env[strtoupper($key)] ?? null;
    }
}