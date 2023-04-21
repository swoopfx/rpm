<?php

namespace General\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pick Up or Drop Off
 * @ORM\Entity
 * @ORM\Table(name="waste_request_type")
 */

class WasteRequestType
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
     * 
     * @ORM\Column(nullable=false)
     * @var string
     */
    private $type;

    /**
     * Get @ORM\Column(name="id", type="integer", nullable=false)
     *
     * @return  integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of type
     *
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param  string  $type
     *
     * @return  self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
}
