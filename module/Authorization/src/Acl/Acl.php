<?php

namespace Authorization\Acl;

use Authentication\Entity\Roles;
use Doctrine\ORM\EntityManager;
use Laminas\Permissions\Acl\Role\GenericRole as Role;
use Laminas\Permissions\Acl\Resource\GenericResource as Resource;
// use Authorization\Entity\Resource;
use Laminas\Permissions\Acl\Acl as AclAcl;

class Acl extends AclAcl
{

    
    private $roles;

    private $resouce;

    private $privilege;


    const DEFAULT_ROLE =  "guest";


    public function __construct()
    {
        
        
    }



    public function _addRoles($roles)
    {
        foreach ($roles as $role) {
            if (!$this->hasRole($role->getName())) {
                $parents = $role->getParents()->toArray();
                $parentNames = array();
                foreach ($parents as $parent) {
                    $parentNames[] = $parent->getName();
                }
                $this->addRole(new Role($role->getName()), $parentNames);
            }
        }

        return $this;
    }



    /**
     * protected function 
     *
     * @param array $resources
     * @param array $privileges
     * @return void
     */
    public function _addAclRules($resources, $privileges)
    {

        foreach ($resources as $resource) {
            if (!$this->hasResource($resource->getName())) {
                $this->addResource(new Resource($resource->getName()));
            }
        }

        foreach ($privileges as $privilege) {
            if ($privilege->getPermissionAllow()) {
                $this->allow($privilege->getRole()->getName(), $privilege->getResource()->getName(), $privilege->getName());
            } else {
                $this->deny($privilege->getRole()->getName(), $privilege->getResource()->getName(), $privilege->getName());
            }
        }

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  EntityManager
     */ 
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set undocumented variable
     *
     * @param  EntityManager  $entityManager  Undocumented variable
     *
     * @return  self
     */ 
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
