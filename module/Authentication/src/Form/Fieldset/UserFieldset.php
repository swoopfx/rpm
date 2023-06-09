<?php

namespace Authentication\Form\Fieldset;

use Authentication\Entity\User;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use DoctrineModule\Validator\NoObjectExists;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Laminas\Validator\StringLength;

class UserFieldset extends Fieldset implements InputFilterProviderInterface{

    private $entityManager;

    
    public function init()
    {
        $hydrator  = new DoctrineObject($this->entityManger);
        $this->setHydrator($hydrator)->setObject(new User());

        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'options' => array(
                'label' => 'Staff Username',
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            'attributes' => array(
                'class' => 'form-control col-md-9 col-xs-12',
                'id' => 'username',
                'required' => 'required',
                'title' => 'Provide Staffs phone number'
            )
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'Laminas\Form\Element\Email',
            'options' => array(
                'label' => 'Staff Email',
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            'attributes' => array(
                'id' => 'staff_email',
                'required' => 'required',
                'class' => 'form-control col-md-9 col-xs-12',
                'title' => 'Provide Email accessible by the staff',
                'placeholder' => 'az@xyz.com'
            )
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Laminas\Form\Element\Password',
            'options' => array(
                'label' => 'Proposed Password',
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            'attributes' => array(
                'id' => 'password',
                'required' => 'required',
                'class' => 'form-control col-md-9 col-xs-12'
            )
        ));
        
        $this->add(array(
            'name' => 'passwordVerify',
            'type' => 'Laminas\Form\Element\Password',
            'options' => array(
                'label' => 'Confirm Password',
                'label_attributes' => array(
                    'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                )
            ),
            'attributes' => array(
                'class' => 'form-control col-md-9 col-xs-12',
                'id' => 'passwordVerify',
                'required' => 'required'
            )
        ));
       
        
        $this->add(array(
            'name' => 'usernameOrEmail',
            'type' => 'text',
            'options' => array(
                'label' => 'Username',
                'label_attributes' => array(
                    'class' => ''
                )
            ),
            'attributes' => array(
                'class' => 'form-control col-md-9 col-xs-12',
                'id' => 'username',
                'required' => 'required',
                'title' => 'Provide Staffs phone number'
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
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
            ),
            
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
            ),
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
                            'object_repository' => $this->entityManager->getRepository('CsnUser\Entity\User'),
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
            ),
            'username' => array(
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
                    array(
                        
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'use_context' => false,
                            'object_repository' => $this->entityManager->getRepository('CsnUser\Entity\User'),
                            'object_manager' => $this->entityManager,
                            'fields' => [
                                'username'
                            ],
                            'use_context' => true,
                            'messages' => array(
                                NoObjectExists::ERROR_OBJECT_FOUND => 'Someone else is registered with this phone number'
                            )
                        )
                    ),
                    
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 9,
                            'max' => 11,
                            'messages' => array(
                                StringLength::TOO_SHORT => 'Please insert the correct amount of digits',
                                StringLength::TOO_LONG => 'We dont think this is a genuine phone number'
                            )
                        )
                    )
                )
            )
        );
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