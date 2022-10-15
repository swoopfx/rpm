<?php

namespace Authentication\Service;


class JWTConfiguration
{
    private $configuration;

    public function setConfiguration($config)
    {
        $this->configuration = $config;
        return $this;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }
}
