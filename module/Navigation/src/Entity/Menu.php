<?php

namespace Navigation\Entity;

use Doctrine\ORM\Mapping as ORM;
use Authentication\Entity\Roles;
use Authorization\Entity\Resource;
use Authorization\Entity\Privilege;

/**
 * Entity for the menu
 * @ORM\Entity
 * @ORM\Table(name="menu")
 * @author Kiel <ezekiel_a@yahoo.com>
 */
class Menu
{

    /**
     *
     * @var integer 
     * @ORM\Column(name="id", type="integer")
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Label of the menu
     * @ORM\Column(nullable=false)
     *
     * @var string
     */
    private $label;

    /**
     * Reference to the role active 
     *
     * @ORM\ManyToOne(targetEntity="Authentication\Entity\Roles")
     * @var Roles
     */
    private $role;



    /**
     * Resources accessed
     * @ORM\ManyToOne(targetEntity="Authorization\Entity\Resource")
     * @var Resource
     */
    private $resource;

    /**
     * Privelege Used
     * @ORM\ManyToOne(targetEntity="Authorization\Entity\Privilege")
     *
     * @var Privilege
     */
    private $privilege;

    /**
     * Controller Action rreferenced
     *
     *  @ORM\Column(nullable=true)
     * @var string
     */
    private $action;

    /**
     * Controller 
     *
     * @ORM\Column(nullable=true)
     * @var string
     */
    private $controller;

    /**
     * If the menu is root
     * @ORM\Column(type="boolean", nullable=false, options={"default" : 0})
     * @var bool
     */
    private $isRoot;

    /**
     * Undocumented variable
     * @ORM\OneToOne(targetEntity="Navigation\Entity\Menu")
     * @var Navigation\Entity\Menu
     */
    private $parent; // self referencing

    /**
     * If this link is a link to exter url 
     * @ORM\Column(type="boolean", nullable=false, options={"default" : 1})
     * @var bool
     */
    private $isExternal; // #

    /**
     * External Url
     * @ORM\Column(type="string", nullable=true,  options={"default" : "#"})
     *
     * @var string
     */
    private $externalUrl;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \Datetime
     */
    private $createdOn;

    /**
     * Undocumented variable
     * @ORM\Column(type="datetime", nullable=false)
     * @var \Datetime
     */
    private $updatedOn;



    

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
     * Set the value of id
     *
     * @param  integer  $id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get label of the menu
     *
     * @return  string
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label of the menu
     *
     * @param  string  $label  Label of the menu
     *
     * @return  self
     */ 
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get reference to the role active
     *
     * @return  Roles
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set reference to the role active
     *
     * @param  Roles  $role  Reference to the role active
     *
     * @return  self
     */ 
    public function setRole(Roles $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get resources accessed
     *
     * @return  Resource
     */ 
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set resources accessed
     *
     * @param  Resource  $resource  Resources accessed
     *
     * @return  self
     */ 
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get privelege Used
     *
     * @return  Privilege
     */ 
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * Set privelege Used
     *
     * @param  Privilege  $privilege  Privelege Used
     *
     * @return  self
     */ 
    public function setPrivilege(Privilege $privilege)
    {
        $this->privilege = $privilege;

        return $this;
    }

    /**
     * Get controller Action rreferenced
     *
     * @return  string
     */ 
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set controller Action rreferenced
     *
     * @param  string  $action  Controller Action rreferenced
     *
     * @return  self
     */ 
    public function setAction(string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get controller
     *
     * @return  string
     */ 
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set controller
     *
     * @param  string  $controller  Controller
     *
     * @return  self
     */ 
    public function setController(string $controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get if this link is a link to exter url
     *
     * @return  bool
     */ 
    public function getIsExternal()
    {
        return $this->isExternal;
    }

    /**
     * Set if this link is a link to exter url
     *
     * @param  bool  $isExternal  If this link is a link to exter url
     *
     * @return  self
     */ 
    public function setIsExternal(bool $isExternal)
    {
        $this->isExternal = $isExternal;

        return $this;
    }

    /**
     * Get if the menu is root
     *
     * @return  bool
     */ 
    public function getIsRoot()
    {
        return $this->isRoot;
    }

    /**
     * Set if the menu is root
     *
     * @param  bool  $isRoot  If the menu is root
     *
     * @return  self
     */ 
    public function setIsRoot(bool $isRoot)
    {
        $this->isRoot = $isRoot;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  Navigation\Entity\Menu
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set undocumented variable
     *
     * @param  Navigation\Entity\Menu  $parent  Undocumented variable
     *
     * @return  self
     */ 
    public function setParent(Menu $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get external Url
     *
     * @return  string
     */ 
    public function getExternalUrl()
    {
        return $this->externalUrl;
    }

    /**
     * Set external Url
     *
     * @param  string  $externalUrl  External Url
     *
     * @return  self
     */ 
    public function setExternalUrl(string $externalUrl)
    {
        $this->externalUrl = $externalUrl;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */ 
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $createdOn  Undocumented variable
     *
     * @return  self
     */ 
    public function setCreatedOn(\Datetime $createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */ 
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $updatedOn  Undocumented variable
     *
     * @return  self
     */ 
    public function setUpdatedOn(\Datetime $updatedOn)
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }
}
