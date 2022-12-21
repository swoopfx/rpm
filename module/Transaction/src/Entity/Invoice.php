<?php

namespace Transaction\Entity;


use Authentication\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="Transactions\Entity\Repository\InvoiceRepository")
 */
class Invoice
{

    /**
     *
     * @var integer This is only genertated upon successful transaction
     *      @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * The customer entity involved in the transaction
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\User")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * 
     * @var Customer
     */
    private $customer;

    /**
     * The date the invoice eas generated
     * @var \DateTime @ORM\Column(name="generated_on", type="datetime", nullable=true)
     */
    private $generatedOn;

    /**
     * The amount meant to be transacted
     * @var string @ORM\Column(name="amount", type="string")
     */
    private $amount;

    /**
     * The category of the invoice , be it SMS Paymen, subscription etc 
     * @ORM\ManyToOne(targetEntity="Transaction\Entity\InvoiceCategory")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="invoice_category", referencedColumnName="id")
     * })
     *
     * @var InvoiceCategory
     */
    private $invoiceCategory;

    /**
     * The related transaction or reciept on successful payment or unsccessful Payment
     * @var Collection @ORM\OneToMany(targetEntity="Transaction\Entity\Transaction", mappedBy="invoice", cascade={"persist", "remove"})
     */
    private $transaction;

    /**
     * 
     * @var string @ORM\Column(name="invoice_uid", type="string", nullable=false)
     */
    private $invoiceUid;

    /**
     * setteled or unsettled
     *
     * @var \Transaction\Entity\InvoiceStatus
     *  @ORM\ManyToOne(targetEntity="Transaction\Entity\InvoiceStatus")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     *      })
     */
    private $status;

    /**
     *
     * @var \General\Entity\Currency @ORM\ManyToOne(targetEntity="General\Entity\Currency")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     *      })
     *     
     *     
     *     
     */
    private $currency;

    /**
     *
     * @var \DateTime @ORM\Column(name="modified_on", type="datetime", nullable=true)
     */
    private $modifiedOn;



    /**
     * This defines it the invoice is still valid /open for payment if
     * Invoice is Closed there will be no link to payout
     *
     * @var boolean @ORM\Column(name="is_open", type="boolean", nullable=true, options={"default":true})
     */
    private $isOpen = true;





    /**
     * @ORM\Column(name="expiry_date", type="datetime", nullable=true)
     * 
     * @var \DateTime
     */
    private $expiryDate;

   


    public function __construct()
    {
        $this->microPayment = new ArrayCollection();
    }

    

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer($cus)
    {
        $this->customer = $cus;
        return $this;
    }

    

    /**
     * Set generatedOn
     *
     * @param \DateTime $generatedOn            
     *
     * @return Invoice
     */
    public function setGeneratedOn($generatedOn)
    {
        $this->generatedOn = $generatedOn;
        $this->modifiedOn = $generatedOn;
        $this->expiryDate = $generatedOn;

        return $this;
    }

    /**
     * Get generatedOn
     *
     * @return \DateTime
     */
    public function getGeneratedOn()
    {
        return $this->generatedOn;
    }

   

    /**
     * Set amountPayed
     *
     * @param string $amountPayed            
     *
     * @return Invoice
     */
    public function setAmount($amountPayed)
    {
        $this->amount = $amountPayed;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set amountDue
     *
     * @param string $amountDue            
     *
     * @return Invoice
     */
    public function setAmountDue($amountDue)
    {
        $this->amountDue = $amountDue;

        return $this;
    }

    /**
     * Get amountDue
     *
     * @return string
     */
    public function getAmountDue()
    {
        return $this->amountDue;
    }

    /**
     * Set balance
     *
     * @param string $balance            
     *
     * @return Invoice
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    
    public function addTransaction(Transaction $trans)
    {
        if (!$this->transaction->contains($trans)) {
            $this->transaction->add($trans);
        }

        return $this;
    }

    public function removeTransaction(Transaction $trans)
    {
        if ($this->transaction->contains($trans)) {
            $this->transaction->removeElement($trans);
        }
        return $this;
    }

    /**
     * Get transaction
     *
     * @return \Transactions\Entity\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     *
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param InvoiceStatus $status            
     *
     * @return Invoice
     */
    public function setStatus(InvoiceStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return object $user
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

    /**
     * Get status
     *
     * @return InvoiceStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @param Invoice $uid            
     */
    public function setInvoiceUid($uid)
    {
        $this->invoiceUid = $uid;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getInvoiceUid()
    {
        return $this->invoiceUid;
    }

    /**
     *
     * @return \Transactions\Entity\InvoiceCategory
     */
    public function getInvoiceCategory()
    {
        return $this->invoiceCategory;
    }

    /**
     *
     * @param \Transactions\Entity\InvoiceCategory $cat            
     * @return \Transactions\Entity\Invoice
     */
    public function setInvoiceCategory($cat)
    {
        $this->invoiceCategory = $cat;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($cur)
    {
        $this->currency = $cur;

        return $this;
    }

    public function getModifiedOn()
    {
        return $this->modifiedOn;
    }

    public function setModifiedOn($mod)
    {
        $this->modifiedOn = $mod;
        return $this;
    }

    public function getIsOpen()
    {
        return $this->isOpen;
    }

    public function setIsOpen($bool)
    {
        $this->isOpen = $bool;
        return $this;
    }

    public function setBroker($brk)
    {
        $this->broker = $brk;
        return $this;
    }

    public function getBroker()
    {
        return $this->broker;
    }

    public function getBrokerCustomerInvoice()
    {
        return $this->brokerCustomerInvoice;
    }

    public function setBrokerCustomerInvoice($bci)
    {
        $this->brokerCustomerInvoice = $bci;
        return $this;
    }

    public function getInvoiceUser()
    {
        return $this->invoiceUser;
    }

    public function setExpiryDate($date)
    {
        $this->expiryDate = $date;
        return $this;
    }

    public function getExpiryDate()
    {
        return $this->expiryDate;
    }
}
