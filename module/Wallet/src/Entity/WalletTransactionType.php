<?php
namespace Wallet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="wallet_transaction_type")
 * @author otaba
 *        
 */
class WalletTransactionType
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;

    /**
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     * @var string
     */
    private $type;
    

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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

//     /**
//      * @param number $id
//      */
//     public function setId($id)
//     {
//         $this->id = $id;
//     }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

}

