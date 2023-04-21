<?php

namespace Customer\Controller\Factory;

use Customer\Controller\CustomerController;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class CustomerControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $ctr = new CustomerController();
        if (!$container->has("general_service")) {
            throw new \InvalidArgumentException("General Service cannot be retrieved at Customer controller Factory");
        }
        $generalService = $container->get("general_service");
        $ctr->setEntityManager($generalService->getEm());
        return $ctr;
    }
}
