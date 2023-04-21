<?php

namespace Customer\Entity;

use General\Entity\WasteRequestType;

class WasteRequest
{
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    private $user;

    /**
     * Paper, Metal, Plastics , Compost
     *
     * @var 
     */
    private $wasteType;

    /**
     * Pickup or DroppOff
     * @ORM\ManyToOne(targetEntity="General\Entity\WasteRequestType")
     * @var WasteRequestType
     */
    private $requestType;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $pickupAddress;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $pickupPlaceId;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $longitude;

    /**
     * Date the Pick up or drop off would take place
     *
     * @var \Datetime
     */
    private $requestDate;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $note;

    private $latitude;

    private $requestId;

    private $requestUid;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $isActive;

    private $createdOn;

    private $updatedOn;
}
