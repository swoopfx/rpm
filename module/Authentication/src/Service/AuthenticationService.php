<?php
namespace Authentication\Service;

use Authentication\Entity\User;
use Laminas\Crypt\Password\Bcrypt;

class AuthenticationService{



    private $em ;

    private $auth;

    public function authenticate(){

    }

    const USER_ROLE_SETUP_BROKER = 3;

    const USER_ROLE_SETUP_AGENT = 2;

    const USER_ROLE_BROKER = 200;

    const USER_ROLE_BROKER_CHILD = 210;

    const USER_ROLE_AGENT = 100;
    
    const USER_ROLE_CUSTOMER = 25;
    
    
    const USER_STATE_DISABLED = 1;
    
    const USER_STATE_ENABLED = 2;


    private $authenticationService;

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