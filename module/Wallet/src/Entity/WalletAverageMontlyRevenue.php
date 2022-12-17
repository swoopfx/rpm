<?php
namespace Wallet\Entity;

use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 * This is an estimated  revenuefor every month 
 * It is  calculated from the activity of the previous month and an average is calculated
 * 
 * @ORM\Entity
 * @ORM\Table(name="wallet_monthly_average_revenue")
 * @author otaba
 *        
 */
class WalletAverageMontlyRevenue
{
    
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
     * @var User
     */
    private $user;
    
    /**
     * @ORM\Column(name="revenue", type="string", nullable=true)
     * @var string
     */
    private $revenue;
    
    private $biengFor;
    
    
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedOn;
    
    

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $revenue
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return the $updatedOn
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $revenue
     */
    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;
        return $this;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    /**
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }
    /**
     * @return  $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \CsnUser\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


}

