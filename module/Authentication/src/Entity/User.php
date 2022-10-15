<?php

namespace Authentication\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */

class User
{
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(length=30, nullable=false, unique=true)
     */
    protected $username;


    /**
     * @ORM\Column(length=30, nullable=false, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="password", length=60, nullable=false)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="Roles")
     */
    private $role;

    private $state;


    private $question;

    /**
     * @var string @ORM\Column(name="answer", type="string", length=100, nullable=true)
     */
    private $answer;

    /**
     *
     * @var \DateTime @ORM\Column(name="registration_date", type="datetime", nullable=true)
     */
    protected $registrationDate;

    /**
     *
     * @var string @ORM\Column(name="registration_token", type="string", length=32, nullable=true)
     */
    protected $registrationToken;

    /**
     *
     * @var boolean @ORM\Column(name="email_confirmed", type="boolean", nullable=false)
     */
    protected $emailConfirmed;

    

    /**
     * @ORM\Column(name="is_profiled", type="boolean", nullable=true)
     *
     * @var boolean
     */
    private $isProfiled;

    /* 
    * @ORM\Column(name="updated_on", type="datetime", nullable=true)
    * 
    * @var \DateTime
    */
    private $updatedOn;

    /* 
    * @ORM\Column(name="created_on", type="datetime", nullable=true)
    * 
    * @var \DateTime
    */
    private $createdOn;


    private $uid;
}
