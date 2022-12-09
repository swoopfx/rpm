<?php

namespace Authentication\Service\Factory;

use Authentication\Service\RegisterService;
use Exception;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RegisterServiceFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $xserv = new RegisterService();
        if (!$container->has("general_service")) {
            throw new \InvalidArgumentException("Register Service cannot retrieve general service");
        }
        if($container->has("postmark_email_authentication_service")){
            throw new Exception("Register Service cannot retrieve postmart email authentication service");
        }
        $generalService = $container->get("general_service");
        $postmarkMailService = $container->get("postmark_email_authentication_service");
        $xserv->setGeneralService($generalService)->setPostmarkAuthMailService($postmarkMailService);
        return $xserv;

    }
}