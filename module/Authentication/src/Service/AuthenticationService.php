<?php

namespace Authentication\Service;

use Authentication\Entity\User;
use Laminas\Crypt\Password\Bcrypt;

class AuthenticationService
{



    private $em;

    private $auth;



    const USER_ROLE_SETUP_BROKER = 3;

    const USER_ROLE_SETUP_AGENT = 2;

    // RP user role

    const USER_ROLE_CUSTOMER = 100;

    const USER_ROLE_DORI_HOST = 200;

    // End RP User 

    const USER_ROLE_BROKER = 200;

    const USER_ROLE_BROKER_CHILD = 210;

    const USER_ROLE_AGENT = 100;

    // const USER_ROLE_CUSTOMER = 25;


    const USER_STATE_DISABLED = 2;

    const USER_STATE_ENABLED = 1;

    const USER_STATE_PENDING = 3;


    private $authenticationService;


    public function authenticate()
    {
    }

    /**
     * Static function for checking hashed password (as required by Doctrine)
     *
     * @param Authentication\Entity\User $user
     *            The identity object
     * @param string $passwordGiven
     *            Password provided to be verified
     * @return boolean true if the password was correct, else, returns false
     */
    public static function verifyHashedPassword(User $user, $passwordGiven)
    {
        $bcrypt = new Bcrypt(array(
            'cost' => 10
        ));
        return $bcrypt->verify($passwordGiven, $user->getPassword());
    }

   /**
    * Undocumented function
    *
    * @param string $systemCode
    * @param string $inputedCode
    * @return boolean
    */
    public static function verifyHashedCode($systemCode, $inputedCode): bool
    {
        $bcrypt = new Bcrypt([
            "cost"=>10
        ]);
        return $bcrypt->verify($inputedCode, $systemCode);
    }

    /**
     * Encrypt Password
     *
     * Creates a Bcrypt password hash
     *
     * @return String
     */
    public static function encryptPassword($password)
    {
        // $crypt = new Bcrcomposer update 
        $bcrypt = new Bcrypt(array(
            'cost' => 10
        ));
        return $bcrypt->create($password);
    }




    /**
     * Get the value of authenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /**
     * Set the value of authenticationService
     *
     * @return  self
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;

        return $this;
    }
}
