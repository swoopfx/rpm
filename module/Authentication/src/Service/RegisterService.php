<?php

namespace Authentication\Service;

use General\Service\Postmark\AuthenticationEmailService;
use Authentication\Entity\Roles;
use Ramsey\Uuid\Uuid;
use Authentication\Entity\User;
use Authentication\Entity\UserState;
use Exception;
use General\Service\GeneralService;
use Authentication\Form\InputFilter\RegisterInputfilter;
use DateTime;
use Doctrine\ORM\EntityManager;


class RegisterService
{

    /**
     * Undocumented variable
     *
     * @var AuthenticationEmailService;
     */
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

    /**
     * Undocumented variable
     *
     * @var Laminas\Mvc\Controller\Plugin\Url
     */
    private $urlPlugin;

    public function register()
    {
        $post = $this->post;
        /**
         * @var EntityManager
         */
        $em = $this->generalService->getEm();
        $designatedRole = NULL;
        if (is_null($this->assignedRole)) {
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

            $activationToken = uniqid(mt_rand(), true);
            $webActivationLink = $this->generateMobileCode($activationToken);

            $mobileActivationCode = self::generateMobileCode();
            $mailData = [];
            $mailData["url"] = $webActivationLink;
            $mailData["code"] = $mobileActivationCode;

            $newUser->setUsername($data["username"])
                ->setPassword(AuthenticationService::encryptPassword($data["password"]))
                ->setFullname($data["fullname"])->setEmail($data["email"])->setRole($em->find(Roles::class, $designatedRole))
                ->setCreatedOn(new \Datetime())
                ->setEmail($data["email"])
                ->setState($em->find(UserState::class, AuthenticationService::USER_STATE_ENABLED))
                ->setRegistrationDate(new \Datetime("now"))
                ->setEmailConfirmed(FALSE)->setIsProfiled(FALSE)
                ->setUid(self::createUid())
                ->setMobileActivateCode($mobileActivationCode)
                ->setRegistrationToken($activationToken)
                ->setUuid(self::createUUid());

            //trigger other events 


            // send email
            $roleEntity = $em->find(Roles::class, $designatedRole);
            $mailData["email"] = $data["email"];
            $mailData["fullname"] = $data["fullname"];
            $mailData["role"] = $roleEntity->getName();


            if ($post["device_type"] == "mobile") {
                $this->mobileMailNotifer($mailData);
            } else {
                $this->webMailNotifier($mailData);
            }
            $em->persist($newUser);
            $em->flush();
            return $data;
        } else {
            throw new \Exception(json_encode($this->registerInputFilter->getMessages()));
        }
    }


    public static function generateMobileCode()
    {
        return AuthenticationService::encryptPassword(mt_rand(100000, 999999));
    }

    public function generateWebActivationLink($activationCode)
    {
        return $this->urlPlugin->fromRoute("api-auth", ["action" => "verify", "id" => $activationCode]);
    }


    private function webMailNotifier($data)
    {
        /**
         * @var AuthenticationEmailService
         */
        $this->postmarkAuthMailService->setData($data)->confirmEmailWeb();
    }

    private function mobileMailNotifer($data)
    {
        $this->postmarkAuthMailService->setData($data)->confirmEmailMobile();
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

    /**
     * Get the value of urlPlugin
     */
    public function getUrlPlugin()
    {
        return $this->urlPlugin;
    }

    /**
     * Set the value of urlPlugin
     *
     * @return  self
     */
    public function setUrlPlugin($urlPlugin)
    {
        $this->urlPlugin = $urlPlugin;

        return $this;
    }
}
