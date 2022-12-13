<?php

namespace Authentication\Service;

use Authentication\Entity\Roles;
use Ramsey\Uuid\Uuid;
use Authentication\Entity\User;
use Authentication\Entity\UserState;
use Exception;
use General\Service\GeneralService;
use Authentication\Form\InputFilter\RegisterInputfilter;
use DateTime;
use Doctrine\ORM\EntityManager;

use function PHPUnit\Framework\isNull;

class RegisterService
{

    private $postmarkAuthMailService;

    /**
     * Undocumented variable
     *
     * @var GeneralService
     */
    private $generalService;

    private $assignedRole = NULL;

    private $post;

    /**
     * Undocumented variable
     *
     * @var RegisterInputfilter
     */
    private $registerInputFilter;

    public function register()
    {
        $post = $this->post;
        /**
         * @var EntityManager
         */
        $em = $this->generalService->getEm();
        $designatedRole = NULL;
        if (isNull($this->assignedRole)) {
            $designatedRole = AuthenticationService::USER_ROLE_CUSTOMER;
        } else {
            $designatedRole = $this->assignedRole;
        }

        if ($post == null) {
            throw new \Exception("Post data is required");
        }

        $this->registerInputFilter->setValidationGroup([
            "username",
            "fullname",
            "email",
            "password",
            "passwordVerify",

        ]);

        $this->registerInputFilter->setData($post);
        if ($this->registerInputFilter->isValid()) {
            $data = $this->registerInputFilter->getValues();
            $newUser = new User();

            $newUser->setUsername($data["username"])
                ->setPassword(AuthenticationService::encryptPassword($data["password"]))
                ->setFullname($data["fullname"])->setEmail($data["email"])->setRole($em->find(Roles::class, $designatedRole))
                ->setCreatedOn(new \Datetime())
                ->setState($em->find(UserState::class, AuthenticationService::USER_STATE_ENABLED))
                ->setRegistrationDate(new \Datetime("now"))
                ->setEmailConfirmed(FALSE)->setIsProfiled(FALSE)
                ->setUid(self::createUid())
                ->setRegistrationToken(uniqid(mt_rand(), true))
                ->setUuid(self::createUUid());

                //trigger other events 

                // send email
                if($post["device_type"] == "mobile"){
                    $this->mobileMailNotifer();
                }else{
                    $this->webMailNotifier();
                }
            $em->persist($newUser);

        } else {
            throw new Exception(json_encode($this->registerInputFilter->getMessages()));
        }
    }


    private function webMailNotifier()
    {
    }

    private function mobileMailNotifer()
    {
    }

    public static function createUUid()
    {
        $uuid = Uuid::uuid4();
        return $uuid->toString();
    }

    public static function createUid()
    {
        return uniqid("resu");
    }


    /**
     * Get the value of generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * Set the value of generalService
     *
     * @return  self
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;

        return $this;
    }

    /**
     * Get the value of postmarkAuthMailService
     */
    public function getPostmarkAuthMailService()
    {
        return $this->postmarkAuthMailService;
    }

    /**
     * Set the value of postmarkAuthMailService
     *
     * @return  self
     */
    public function setPostmarkAuthMailService($postmarkAuthMailService)
    {
        $this->postmarkAuthMailService = $postmarkAuthMailService;

        return $this;
    }

    /**
     * Get the value of registerInputFilter
     */
    public function getRegisterInputFilter()
    {
        return $this->registerInputFilter;
    }

    /**
     * Set the value of registerInputFilter
     *
     * @return  self
     */
    public function setRegisterInputFilter($registerInputFilter)
    {
        $this->registerInputFilter = $registerInputFilter;

        return $this;
    }

    /**
     * Get the value of assignedRole
     */
    public function getAssignedRole()
    {
        return $this->assignedRole;
    }

    /**
     * Set the value of assignedRole
     *
     * @return  self
     */
    public function setAssignedRole($assignedRole)
    {
        $this->assignedRole = $assignedRole;

        return $this;
    }
}
