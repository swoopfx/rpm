<?php

namespace Authentication\Controller\Factory;

use Authentication\Controller\ApiauthenticateController;
use Authentication\Service\ApiAuthenticateService;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ApiauthenticateControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new ApiauthenticateController();
        if (!$container->has(ApiAuthenticateService::class)) {
            throw new \InvalidArgumentException("Api Authetication Service cannot be retrieved at Api authentication controller");
        }
        if(!$container->has("general_service")){
            throw new \InvalidArgumentException("Api Authetication Service cannot be retrieved at Api authentication controller");
        }
        $apiAutheticateService = $container->get(ApiAuthenticateService::class);
        $generalService = $container->get("general_service");
       
        return $ctr;
    }
}
