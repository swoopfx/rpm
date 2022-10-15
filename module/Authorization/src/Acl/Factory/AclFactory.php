<?php

namespace Authorization\Acl\Factory;

use Authentication\Entity\Roles;
use Authorization\Acl\Acl;
use Authorization\Entity\Privilege;
use Authorization\Entity\Resource;
use Doctrine\ORM\EntityManager;
use Exception;
// use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use General\Service\GeneralService;

class AclFactory implements FactoryInterface
{


    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $acl = new Acl();
        if (!$container->has("general_service")) {
            throw new \InvalidArgumentException("Acl Factory could not retrieve general service");
        }
        /**
         * @var  GeneralService
         */
        $generalService = $container->get("general_service");
        /**
         * @var EntityManager
         */
        $em = $generalService->getEm();
        if (!class_exists("Authentication\Entity\Roles")) {
            throw new \Exception("Roles class cannot be reached from Acl Factory");
        }
        $roles = $em->getRepository(Roles::class)->findAll();
        $resourece = $em->getRepository(Resource::class)->findAll();
        $privilege = $em->getRepository(Privilege::class)->findAll();

        $acl->_addRoles($roles)->_addAclRules($resourece, $privilege);
        return $acl;
    }
}
