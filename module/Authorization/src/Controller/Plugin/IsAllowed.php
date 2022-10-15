<?php

namespace Authorization\Controller\Plugin;

use Authorization\Acl\Acl;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

class IsAllowed extends AbstractPlugin
{


    private $auth;

    private $acl;

    public function __construct($auth, $acl)
    {

        $this->auth = $auth;

        $this->acl = $acl;
    }


    public function __invoke($resource, $privilege)
    {
        if ($this->auth->hasIdentity()) {
            $user = $this->auth->getIdentity()->getRole()->getName();
            if (!$this->acl->hasResource($resource)) {
                throw new \Exception('Resource ' . $resource . ' not defined');
            }
            return $this->acl->isAllowed($user, $resource, $privilege);
        } else {
            return $this->acl->isAllowed(Acl::DEFAULT_ROLE, $resource, $privilege);
        }

    }
}
