<?php
namespace Transaction\Entity;


use Doctrine\ORM\Mapping as ORM;
/**
 * This define the the category of the invocies 
 * 
 * @ORM\Entity
 * @ORM\Table(name="invoice_category")
 * @author swoopfx
 *        
 */
class InvoiceCategory
{
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    private $id;
    
    
    /**
     * @ORM\Column(name="category", type="string", nullable=false)
     *
     * @var string
     */
    private $category;
    
    /**
     * This provide a complimentary description
     * for the invoice and the 
     * e.g payment for the acquisition of a 
     * @var text
     * @ORM\Column(name="category_note", type="text", nullable=true)
     */
    private $categoryNote;
    
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function getId(){
        return $this->id; 
    }
    
    /**
     * 
     * @return string
     */
    public function getCategory(){
        return $this->category;
        
    }
    
    /**
     * 
     * @param string $cat
     * @return \Transactions\Entity\InvoiceCategory
     */
    public function setCategory($cat){
        $this->category = $cat;
        
        return $this;
    }

    /**
     * Get e.g payment for the acquisition of a
     *
     * @return  text
     */ 
    public function getCategoryNote()
    {
        return $this->categoryNote;
    }

    /**
     * Set e.g payment for the acquisition of a
     *
     * @param  text  $categoryNote  e.g payment for the acquisition of a
     *
     * @return  self
     */ 
    public function setCategoryNote($categoryNote)
    {
        $this->categoryNote = $categoryNote;

        return $this;
    }
}

