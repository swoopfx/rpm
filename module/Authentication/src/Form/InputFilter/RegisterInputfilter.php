<?php


namespace Authentication\Form\InputFilter;

use Authentication\Entity\User;
use DoctrineModule\Validator\NoObjectExists;
use Laminas\InputFilter\InputFilter;
use Doctrine\ORM\EntityManager;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Laminas\Validator\StringLength;

class RegisterInputfilter extends InputFilter
{

    /**
     * 
     *
     * @var EntityManager
     */
    private $entityManager;


    public function __construct()
    {
        $this->filter();
    }

    private function filter()
    {
        $this->add(array(
            'name' => 'username',
            'required' => true,
            "allow_empty" => false,
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
                            'isEmpty' => 'Identity is required'
                        )
                    )
                ),
                [
                    "name" => NoObjectExists::class,
                    "options" => [
                        "use_context" => true,
                        "object_repository" => $this->entityManager->getRepository(User::class),
                        "objject_manager" => $this->entityManager,
                        "fields" => [
                            "username"
                        ],
                        "messages" => [
                            NoObjectExists::ERROR_NO_OBJECT_FOUND => "please use another identity"
                        ]
                    ]
                ],
                [
                    'name' => StringLength::class,
                    'options' => array(
                        'messages' => array(),
                        'min' => 6,
                        'max' => 256,
                        'messages' => array(
                            StringLength::TOO_SHORT => 'Try Something more longer',
                            StringLength::TOO_LONG => 'Could you really remember this long identity'
                        )
                    ),
                ]
            )
        ));


        $this->add(array(
            'name' => 'fullname',
            'required' => true,
            "allow_empty" => false,
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
                            'isEmpty' => 'Full Name is required'
                        )
                    )
                ),
                
                [
                    'name' => StringLength::class,
                    'options' => array(
                        'messages' => array(),
                        'min' => 6,
                        'max' => 256,
                        'messages' => array(
                            StringLength::TOO_SHORT => 'Try Something more longer',
                            StringLength::TOO_LONG => 'Could you really remember this long identity'
                        )
                    ),
                ]
            )
        ));


        $this->add([
            'email' => array(
                'required' => true,
                'allow_empty' => false,
                'break_chain_on_failure' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    // array(
                    // 'name' => 'Regex',
                    // 'options' => array(
                    // 'pattern' => '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/',
                    // 'messages' => array(
                    // Regex::NOT_MATCH => 'Please provide a valid email address.'
                    // )
                    // ),
                    // 'break_chain_on_failure' => true
                    // ),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'use_context' => true,
                            'object_repository' => $this->entityManager->getRepository(User::class),
                            'object_manager' => $this->entityManager,
                            'fields' => array(
                                'email'
                            ),
                            'messages' => array(

                                NoObjectExists::ERROR_OBJECT_FOUND => 'Someone else is registered with this email'
                            )
                        )
                    ),
                    array(
                        'name' => 'Laminas\Validator\StringLength',
                        'options' => array(
                            'messages' => array(),
                            'min' => 3,
                            'max' => 256,
                            'messages' => array(
                                StringLength::TOO_SHORT => 'Email Too short',
                                StringLength::TOO_LONG => 'We dont think this is a genuine email'
                            )
                        ),

                       
                    ),
                    array(
                        'name' => 'EmailAddress',

                        'options' => array(

                            'messages' => array(
                                EmailAddress::INVALID_FORMAT => 'Please check your email something is not right'
                            )
                        )
                    )

                )
            )
        ]);

        $this->add([
            "password" => array(
                "required" => true,
                "allow_empty" => false,
                "filters" => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                "validators" => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 50,
                            "messages" => array(
                                StringLength::TOO_SHORT => "The password must be more than 6 characters",
                                StringLength::TOO_LONG => "This password is too long to memorize"
                            )
                        )
                    )
                )
            )
        ]);

        $this->add([
            "passwordVerify" => array(
                "required" => true,
                "allow_empty" => false,
                "validators" => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 6,
                            'max' => 50,
                            "messages" => array(
                                StringLength::TOO_SHORT => "The password must be more than 6 characters",
                                StringLength::TOO_LONG => "This password is too long to memorize"
                            )
                        )
                    ),
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'password',
                            "messages" => array(
                                Identical::NOT_SAME => "The passwords are not identical"
                            )
                        )
                    )
                )
            )
        ]);

        
    }


    /**
     * Get the value of entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }


    /**
     * Set the value of entityManager
     *
     * @return  self
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
