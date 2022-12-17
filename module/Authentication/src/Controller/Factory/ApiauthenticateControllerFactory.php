<?php

namespace Authentication\Controller\Factory;

use Authentication\Controller\ApiauthenticateController;
use Authentication\Service\ApiAuthenticateService;
use Exception;
use General\Service\GeneralService;
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
        if (!$container->has("general_service")) {
            throw new \InvalidArgumentException("Api Authetication Service cannot be retrieved at Api authentication controller");
        }
        if (!$container->has(RegisterService::class)) {
            throw new  \Exception("API Authservice Factory cannot retirve RegisterService::class");
        }
        $registerService = $container->get(RegisterService::class);
        $apiAutheticateService = $container->get(ApiAuthenticateService::class);
        /**
         * @var GeneralService
         */
        $generalService = $container->get("general_service");

        $ctr->setGeneralService($generalService)
            ->setApiAuthService($apiAutheticateService)
            ->setEntityManager($generalService->getEm())
            ->setRegisterService($registerService);

        return $ctr;
    }
}
