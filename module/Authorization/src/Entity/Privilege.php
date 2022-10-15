<?php
/**
 * 
 * 
 * 
 * @author Kiel <ezekiel@imapp.ng>
*/

namespace Authorization\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Privileges
 *
 * @ORM\Table(name="privilege")
 * @ORM\Entity
 * 
 */
class Privilege
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     *
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @var CsnAuthorization\Entity\Resource
     *
     * @ORM\ManyToOne(targetEntity="Resource")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", nullable=true)
     */
    protected $resource;
    
    /**
    * @var CsnUser\Entity\Role
    *
    * @ORM\ManyToOne(targetEntity="Authentication\Entity\Roles")
    * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
    */
    protected $role;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="permission_allow", type="boolean", nullable=false)
     */
    protected $permissionAllow = true;

    /**
     * Set name
     *
     * @param  string   $name
     * @return Privilege
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set resource
     *
     * 
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * 
     */
    public function getResource()
    {
        return $this->resource;
    }
    
    /**
     * Set role
     *
     * @param  Role $role
     * 
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * Set permissionAllow
     *
     * @param  boolean $permissionAllow
     *
     */
    public function setPermissionAllow($permissionAllow)
    {
        $this->permissionAllow = $permissionAllow;

        return $this;
    }
    
    /**
     * Get permissionAllow
     *
     * @return boolean
     */
    public function getPermissionAllow()
    {
        return $this->permissionAllow;
    }
    
}