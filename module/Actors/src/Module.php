<?php
/**
 * This provides functionality for actos like Dori Host etc.
 * 
 */


declare(strict_types=1);

namespace Actors;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
}