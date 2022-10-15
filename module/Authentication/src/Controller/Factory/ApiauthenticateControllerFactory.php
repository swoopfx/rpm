<?php

namespace Authentication\Controller\Factory;

use Authentication\Controller\ApiauthenticateController;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ApiauthenticateControllerFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new ApiauthenticateController();

        return $ctr;
    }
}