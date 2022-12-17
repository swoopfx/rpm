<?php
namespace Wallet\Entity;


use Doctrine\ORM\Mapping as ORM ; 
use Shop\Entity\Cart;
use Transaction\Entity\Transaction;


/**
 * @ORM\Entity
 * @ORM\Table(name="wallet_cart_transaction")
 * @author ezekiel
 *        
 */
class WalletCartTransaction
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Wallet")
     * @var Wallet
     */
    private $wallet;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Cart")
     * @var Cart
     */
    private $cart;
    
    /**
     * @ORM\OneToOne(targetEntity="Transaction\Entity\Transaction")
     * @var Transaction
     */
    private $transaction;
    
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
     * @return the $wallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @return the $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @return the $transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
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
     * @param \Wallet\Entity\Wallet $wallet
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;
        return $this;
    }

    /**
     * @param \Shop\Entity\Cart $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @param \Transaction\Entity\Transaction $transaction
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
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

}

