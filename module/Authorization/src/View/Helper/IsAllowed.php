<?php
namespace Authorization\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\Authentication\AuthenticationService;
use Authorization\Acl\Acl;

class IsAllowed extends AbstractHelper {

    /**
     * Authentication Service
     *
     * @var AuthenticationService
     */
    private $auth;

    /**
     * Authorization parser service
     *
     * @var Acl
     */
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