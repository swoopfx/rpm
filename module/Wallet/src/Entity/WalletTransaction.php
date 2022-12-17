<?php
namespace Wallet\Entity;

use Transactions\Entity\TransactionStatus;
use Doctrine\ORM\Mapping as ORM;
use CsnUser\Entity\User;

/**
 * This is all trancsaction taking place on the wallet, which is categorized as credit and debit
 * @ORM\Entity
 * @ORM\Table(name="wallet_transaction")
 * @author otaba
 *
 */
class WalletTransaction
{
    
    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;
    
//     /**
//      * @ORM\ManyToOne(targetEntity="CsnUser\Entity\User")
//      * @var User
//      */
//     private $user;
    
    /**
     * credit or Debit
     * credit or withrawal
     * @ORM\ManyToOne(targetEntity="WalletTransactionType")
     *
     * @var WalletTransactionType
     */
    private $transactionType;
    
//     /**
//      * @ORM\ManyToOne(targetEntity="Transactions\Entity\TransactionStatus")
//      *
//      * @var TransactionStatus
//      */
//     private $status;
    
    /**
     * @ORM\Column(name="amount", type="string", nullable=true)
     *
     * @var string
     */
    private $amount;
    
    /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedOn;
    
    /**
     * @ORM\ManyToOne(targetEntity="Wallet")
     *
     * @var Wallet
     */
    private $wallet;

    // TODO - Insert your code here
    public function __construct()
    {

        // TODO - Insert your code here
    }
    /**
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return WalletTransactionType
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @return \Transactions\Entity\TransactionStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * @return \Wallet\Entity\Wallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param WalletTransactionType $transactionType
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
        return $this;
        
    }

    /**
     * @param \Transactions\Entity\TransactionStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param \DateTime $createdOn
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        $this->updatedOn = $createdOn;
        return $this;
    }

    /**
     * @param \DateTime $updatedOn
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

    /**
     * @param \Wallet\Entity\Wallet $wallet
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;
        return $this;
    }
//     /**
//      * @return \CsnUser\Entity\User
//      */
//     public function getUser()
//     {
//         return $this->user;
//     }

//     /**
//      * @param \CsnUser\Entity\User $user
//      */
//     public function setUser($user)
//     {
//         $this->user = $user;
//         return $this;
//     }


}

