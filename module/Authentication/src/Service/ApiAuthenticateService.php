<?php

namespace Authentication\Service;

use Authentication\Entity\User;
use Laminas\InputFilter\InputFilter;
use Laminas\Json\Json;
use Authentication\Service\JWTIssuer;
use Laminas\Http\Request;
use Laminas\Http\Response;
use Authentication\Form\InputFilter\RegisterInputfilter;
use Authentication\Form\InputFilter\LoginInputFilter;
use Doctrine\ORM\EntityManager;
use Exception;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Http\Header\SetCookie;
use RuntimeException;

class ApiAuthenticateService implements AuthenticationServiceInterface
{

    /**
     * @var JWTIssuer
     */
    private $jwtIssuer;

    // private $request;

    // private $response;

    /**
     * Register data Validation and filtration calss
     *
     * @var RegisterInputfilter
     */
    private $registerInputFilter;

    /**
     * Login data validation and filtration class
     *
     * @var LoginInputFilter
     */
    private $loginInputFilter;

    /**
     * 
     *
     * @var EntityManager
     */
    private $entityManager;

    private $systemConfig;

    const COOKIE_NAME = "auth";

    private $post;


    /**
     * Http Request Object
     *
     * @var Request
     */
    private $requestObject;

    /**
     * Http Response Object
     *
     * @var Response
     */
    private $responseObject;


    private function getBearerToken()
    {
        $requestObject = $this->requestObject;

        if (!$requestObject->getHeader('Authorization')) {

            throw new \Exception("Authorization Absent");
        } else {
            $authorizationHeader = $requestObject->getHeader('Authorization')->getFieldValue();

            // HEADER: Get the access token from the header
            if (!empty($authorizationHeader)) {
                if (preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {

                    return $matches[1];
                }else{
                    throw new Exception("Improper Bearer Config");
                }
            }
        }
    }


    public function authenticate()
    {
        $post = $this->post;
        if($post == NULL){
            throw new Exception("Set Post function needs to be initiated");
        }
        $inputFilter = $this->loginInputFilter;

        $inputFilter->setValidationGroup([
            "userAgent",
            "userIp",
            "username",
            "password"
        ]);
        $inputFilter->setData($post);

        if ($inputFilter->isValid()) {
            $data = $inputFilter->getValues();
            $authService = $this->authenticationService;
            $adapter = $authService->getAdapter();
            $phoneOrEmail = $data["username"];
            $em = $this->entityManager;
            $user = $em->createQuery("SELECT u FROM CsnUser\Entity\User u WHERE u.email = '$phoneOrEmail' OR u.username = '$phoneOrEmail'")->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);

            if (count($user) == 0) {

                throw new \Exception(Json::encode("Invalid Credentials"));
            }

            /**
             * @var User
             */
            $user = $user[0];

            if (!$user->getEmailConfirmed() == 1) {
                throw new \Exception(Json::encode("You are yet to confirm your email! please go to the registered email to confirm your account"));
            }
            if ($user->getState()->getId() != 1) {
                throw new \Exception(Json::encode("Your account is disabled"));
            }

            $adapter->setIdentity($user->getUsername());
            $adapter->setCredential($data["password"]);

            $authResult = $authService->authenticate();

            if ($authResult->isValid()) {
                $identity = $authResult->getIdentity();
                $authService->getStorage()->write($identity);

                // generate jwt token
                $refresh_uid = uniqid("rt", true); // token to refresh the access token
                $data = [];
                $data["token"] = $this->jwtIssuer->issueToken($user->getId())->toString();
                $data["userid"] = $user->getId();
                $data["expire"] = "";
                $data ["uuid"] = $user->getUid();
                $data["refresh_uid"] = $refresh_uid;

                // Generate refresh token
                // Store in database
                // store in header cookie hhtponly settings
                $refreshData = [];
                $refreshData["ip"] = $data["userIp"];
                $refreshData["user_agent"] = $data["userAgent"];
                $refreshData["refresh_uid"] = $refresh_uid;
                $refreshData["user_id"] = $user->getId();
                $refreshToken = $this->jwtIssuer->generateRefreshToken($refreshData);
                $cookie = new SetCookie(self::COOKIE_NAME);

                $cookie->setValue($refreshToken);
                $cookie->setExpires(60*60*24*30);
                $cookie->setPath("/");
                $cookie->setSecure(true);
                $cookie->setHttponly(true);
                $config = $this->jwtIssuer->getSystemConfig();
                $cookie->setDomain($config["jwt"]["url"]);

                $data["cookie"] = $cookie;


                return $data;
            } else {
                throw new \Exception(Json::encode("Invalid Credentials"));
            }
        } else {
            throw new \Exception(Json::encode($inputFilter->getMessages()));
        }
    }



    public function hasIdentity()
    {
        try {
            if ($this->getIdentity() instanceof  \Exception) {
                return false;
            } else {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }


    public function getIdentity()
    {
        try {

            if ($this->getBearerToken() instanceof \Exception) {

                throw new \Exception("No way");
            } else {
                $jwt = $this->getBearerToken();
                $jwtServe = $this->jwtIssuer;

                $token = $jwtServe->parseToken($jwt);
                if ($token == null) {
                    throw new \Exception("OHHH NO, invalid token");
                } else {

                    $uid = $token->claims()->get("uid");

                    return $uid;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Not Authorized");
        }
    }

    public function clearIdentity()
    {
        return "";
    }



    public function register($post)
    {
        $inputFilter = $this->registerInputFilter;
        $inputFilter->setData($post);
        if ($inputFilter->isValid()) {
            // Extract Data = 
            // Post Data into Database
            // Send mail notification 

        } else {
            throw new \Exception(Json::encode($inputFilter->getMessages()));
        }
    }

    public function refreshToken()
    {
        if(!$this->hasCookie()){
            // throw new RuntimeException("Http Cookie Absent");

            // ceck for refresh uid
            // check for a user id
        }
        $post = $this->post;
        $cookie = $this->readCookie();

        // Search for token  in UserRefresh Token table by  user device and IP
        /*
         * Just to make sure the same device is refreshing the token 
         * if it exist, check if it is still valid
         *
         * 
         */
        
        
    }


    private function hasCookie()
    {
        if (!($this->requestObject instanceof Request)) {
            return false;
        }

        return $this->requestObject->getHeaders()->has('Cookie') && $this->request->getCookie()->offsetExists(self::COOKIE_NAME);
    }

    private function readCookie()
    {
        if (!($this->requestObject instanceof Request)) {
            return null;
        }

        return $this->requestObject->getCookie()->offsetGet(self::COOKIE_NAME);
    }



    public function generate($claim)
    {
        $jwtIssuer = $this->jwtIssuer;

        if ($jwtIssuer instanceof JWTIssuer) {
            return $jwtIssuer->issueToken($claim)->toString();
        }
    }

    public function validate($jwt)
    {
        return $this->jwtIssuer->parseToken($jwt);
    }

    /**
     * Get register data Validation and filtration calss
     *
     * @return  RegisterInputfilter
     */
    public function getRegisterInputFilter()
    {
        return $this->registerInputFilter;
    }

    /**
     * Set register data Validation and filtration calss
     *
     * @param  RegisterInputfilter  $registerInputFilter  Register data Validation and filtration calss
     *
     * @return  self
     */
    public function setRegisterInputFilter(RegisterInputfilter $registerInputFilter)
    {
        $this->registerInputFilter = $registerInputFilter;

        return $this;
    }

    /**
     * Get login data validation and filtration class
     *
     * @return  LoginInputFilter
     */
    public function getLoginInputFilter()
    {
        return $this->loginInputFilter;
    }

    /**
     * Set login data validation and filtration class
     *
     * @param  LoginInputFilter  $loginInputFilter  Login data validation and filtration class
     *
     * @return  self
     */
    public function setLoginInputFilter(LoginInputFilter $loginInputFilter)
    {
        $this->loginInputFilter = $loginInputFilter;

        return $this;
    }

    /**
     * Get the value of entityManager
     *
     * @return  EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set the value of entityManager
     *
     * @param  EntityManager  $entityManager
     *
     * @return  self
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Get the value of jwtIssuer
     *
     * @return  JWTIssuer
     */
    public function getJwtIssuer()
    {
        return $this->jwtIssuer;
    }

    /**
     * Set the value of jwtIssuer
     *
     * @param  JWTIssuer  $jwtIssuer
     *
     * @return  self
     */
    public function setJwtIssuer(JWTIssuer $jwtIssuer)
    {
        $this->jwtIssuer = $jwtIssuer;

        return $this;
    }

    /**
     * Get the value of systemConfig
     */
    public function getSystemConfig()
    {
        return $this->systemConfig;
    }

    /**
     * Set the value of systemConfig
     *
     * @return  self
     */
    public function setSystemConfig($systemConfig)
    {
        $this->systemConfig = $systemConfig;

        return $this;
    }

    /**
     * Get the value of post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set the value of post
     *
     * @return  self
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get http Request Object
     *
     * @return  Request
     */
    public function getRequestObject()
    {
        return $this->requestObject;
    }

    /**
     * Set http Request Object
     *
     * @param  Request  $requestObject  Http Request Object
     *
     * @return  self
     */
    public function setRequestObject(Request $requestObject)
    {
        $this->requestObject = $requestObject;

        return $this;
    }

    /**
     * Get http Response Object
     *
     * @return  Response
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }

    /**
     * Set http Response Object
     *
     * @param  Response  $responseObject  Http Response Object
     *
     * @return  self
     */
    public function setResponseObject(Response $responseObject)
    {
        $this->responseObject = $responseObject;

        return $this;
    }
}
