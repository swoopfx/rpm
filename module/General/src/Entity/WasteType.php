<?php

namespace General\Entity;

use Doctrine\ORM\Mapping;

/**
 * Type of waste, PLastic, bottle, metal, Paper, compost
 * @ORM\Entity
 * @ORM\Table(name="waste_type")
 */
class WasteType
{

    /**
     *
     * @var integer 
     * @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(type="string")
     * @var string
     */
    private $type;

    /**
     * Get the value of id
     *
     * @return  integer
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $type  Undocumented variable
     *
     * @return  self
     */ 
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
}
