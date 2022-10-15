<?php

namespace Authentication\Service;

use Laminas\InputFilter\InputFilter;
use Laminas\Json\Json;
use Authentication\Service\JWTIssuer;

class ApiAuthenticateService {

    /**
     * @var JWTIssuer
     */
    private $jwtIssuer;


    public function authenticate()
    {
        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name' => 'phoneOrEmail',
            'required' => true,
            'allow_empty' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Phone number or email is required'
                        )
                    )
                )
            )
        ));

        $inputFilter->add(array(
            'name' => 'password',
            'required' => true,
            'allow_empty' => false,
            'filters' => array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => 'Password is required'
                        )
                    )
                )
            )
        ));

        $inputFilter->setData($this->authData);

        if ($inputFilter->isValid()) {
            $data = $inputFilter->getValues();
            $authService = $this->authenticationService;
            $adapter = $authService->getAdapter();
            $phoneOrEmail = $data["phoneOrEmail"];
            $em = $this->entityManager;
            $user = $em->createQuery("SELECT u FROM CsnUser\Entity\User u WHERE u.email = '$phoneOrEmail' OR u.phoneNumber = '$phoneOrEmail'")->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);

            if (count($user) == 0) {

                throw new \Exception(Json::encode("Invalid Credentials"));
            }

            $user = $user[0];

            if (! $user->getEmailConfirmed() == 1) {
                throw new \Exception(Json::encode("You are yet to confirm your email! please go to the registered email to confirm your account"));
            }
            if ($user->getState()->getId() < 2) {
                throw new \Exception(Json::encode("Your account is disabled"));
            }

            $adapter->setIdentity($user->getPhoneNumber());
            $adapter->setCredential($data["password"]);

            $authResult = $authService->authenticate();

            if ($authResult->isValid()) {
                $identity = $authResult->getIdentity();
                $authService->getStorage()->write($identity);

                // generate jwt token
                $data = [];
                $data["token"] = $this->jwtService->generate($user->getId());
                $data["userid"] = $user->getId();
                return $data;
            } else {
                throw new \Exception(Json::encode("Invalid Credentials"));
            }
        } else {
            throw new \Exception(Json::encode($inputFilter->getMessages()));
        }
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

}