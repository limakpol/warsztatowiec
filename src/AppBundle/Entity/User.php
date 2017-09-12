<?php

namespace AppBundle\Entity;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $current_workshop_id;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $forename;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $status = 1;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \DateTime
     */
    private $deleted_at;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $roles;

    /**
     * @var \AppBundle\Entity\Workshop
     */
    private $current_workshop;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $workshops;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->workshops = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set currentWorkshopId
     *
     * @param integer $currentWorkshopId
     *
     * @return User
     */
    public function setCurrentWorkshopId($currentWorkshopId)
    {
        $this->current_workshop_id = $currentWorkshopId;

        return $this;
    }

    /**
     * Get currentWorkshopId
     *
     * @return integer
     */
    public function getCurrentWorkshopId()
    {
        return $this->current_workshop_id;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set forename
     *
     * @param string $forename
     *
     * @return User
     */
    public function setForename($forename)
    {
        $this->forename = $forename;

        return $this;
    }

    /**
     * Get forename
     *
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return User
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deleted_at = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * Add role
     *
     * @param \AppBundle\Entity\UserRole $role
     *
     * @return User
     */
    public function addRole(\AppBundle\Entity\UserRole $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \AppBundle\Entity\UserRole $role
     */
    public function removeRole(\AppBundle\Entity\UserRole $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set currentWorkshop
     *
     * @param \AppBundle\Entity\Workshop $currentWorkshop
     *
     * @return User
     */
    public function setCurrentWorkshop(\AppBundle\Entity\Workshop $currentWorkshop = null)
    {
        $this->current_workshop = $currentWorkshop;

        return $this;
    }

    /**
     * Get currentWorkshop
     *
     * @return \AppBundle\Entity\Workshop
     */
    public function getCurrentWorkshop()
    {
        return $this->current_workshop;
    }

    /**
     * Add workshop
     *
     * @param \AppBundle\Entity\Workshop $workshop
     *
     * @return User
     */
    public function addWorkshop(\AppBundle\Entity\Workshop $workshop)
    {
        $this->workshops[] = $workshop;

        return $this;
    }

    /**
     * Remove workshop
     *
     * @param \AppBundle\Entity\Workshop $workshop
     */
    public function removeWorkshop(\AppBundle\Entity\Workshop $workshop)
    {
        $this->workshops->removeElement($workshop);
    }

    /**
     * Get workshops
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkshops()
    {
        return $this->workshops;
    }
}

