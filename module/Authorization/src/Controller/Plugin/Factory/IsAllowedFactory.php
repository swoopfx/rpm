<?php

namespace Authorization\Controller\Plugin\Factory;

use Authorization\Controller\Plugin\IsAllowed as PluginIsAllowed;
use General\Service\GeneralService;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IsAllowedFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if(!$container->has("general_service")){
            throw new \InvalidArgumentException("IsAllowed view Helper Factory cannot retrieve general Service");
        }

        if(!$container->get("acl_service")){
            throw new \InvalidArgumentException("IsAllowed view Helper Factory cannot retrieve Acl Service");
     
        }
        
        /**
         * @var GeneralService
         */
        $generalService  = $container->get("general_service");
        $acl = $container->get("acl_service");
        $auth = $generalService->getAuthService();
        $ctr = new PluginIsAllowed($auth, $acl);
        return $ctr;
        
    }
}