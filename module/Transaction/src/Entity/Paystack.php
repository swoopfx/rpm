<?php

namespace Transaction\Entity;

class Paystack {

     /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    private $createdOn;

    private $updatedOn;

}