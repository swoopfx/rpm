<?php

namespace Authentication\Service\Factory;

use Authentication\Service\ApiAuthenticateService;
use InvalidArgumentException;
use General\Service\GeneralService;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ApiAuthenticateServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new ApiAuthenticateService();
        if (!$container->has("General\Service\GeneralService")) {
            throw new InvalidArgumentException("Api Authentication Service cannot retrieve general service");
        }

        if(!$container->has("Authentication\Service\JWTIssuer")){
            throw new InvalidArgumentException("Api Authentication Service cannot retrieve jwt issuer service");
        }

        $jwtIssuer = $container->get("Authentication\Service\JWTIssuer");
        /**
         * @var GeneralService
         */
        $generalService = $container->get("General\Service\GeneralService");
        return $xserv;
    }
}
