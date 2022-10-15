<?php

namespace Authentication\Service\Factory;

use Authentication\Service\JWTIssuer;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class JWTIssuerFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $issuer = new JWTIssuer();
        $jwt_config = $container->get("Authentication\Service\JWTConfiguration");
        $systemConfig = $container->get("config");

        $issuer->setSystemConfig($systemConfig)->setConfig($jwt_config);
        return $issuer;
    }
}
