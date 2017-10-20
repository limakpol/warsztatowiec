<?php

namespace AppBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface, \Serializable
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
    private $forename;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $password;

    /**
     * @var integer
     */
    private $status = 1;

    /**
     * @var string
     */
    private $hourly_rate_net;

    /**
     * @var string
     */
    private $phone1;

    /**
     * @var string
     */
    private $phone2;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $address_id;

    /**
     * @var string
     */
    private $nip;

    /**
     * @var string
     */
    private $pesel;

    /**
     * @var string
     */
    private $bank_account_number;

    /**
     * @var string
     */
    private $remarks;

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
    private $removed_at;

    /**
     * @var \DateTime
     */
    private $deleted_at;

    /**
     * @var integer
     */
    private $created_by_id;

    /**
     * @var integer
     */
    private $updated_by_id;

    /**
     * @var integer
     */
    private $removed_by_id;

    /**
     * @var integer
     */
    private $deleted_by_id;

    /**
     * @var \AppBundle\Entity\Address
     */
    private $address;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $roles;

    /**
     * @var \AppBundle\Entity\Workshop
     */
    private $current_workshop;

    /**
     * @var \AppBundle\Entity\User
     */
    private $created_by;

    /**
     * @var \AppBundle\Entity\User
     */
    private $updated_by;

    /**
     * @var \AppBundle\Entity\User
     */
    private $removed_by;

    /**
     * @var \AppBundle\Entity\User
     */
    private $deleted_by;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $workshops;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $order_services;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $order_actions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $positions;

    private $username;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->workshops = new \Doctrine\Common\Collections\ArrayCollection();
        $this->order_services = new \Doctrine\Common\Collections\ArrayCollection();
        $this->order_actions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->positions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set hourlyRateNet
     *
     * @param string $hourlyRateNet
     *
     * @return User
     */
    public function setHourlyRateNet($hourlyRateNet)
    {
        $this->hourly_rate_net = $hourlyRateNet;

        return $this;
    }

    /**
     * Get hourlyRateNet
     *
     * @return string
     */
    public function getHourlyRateNet()
    {
        return $this->hourly_rate_net;
    }

    /**
     * Set phone1
     *
     * @param string $phone1
     *
     * @return User
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;

        return $this;
    }

    /**
     * Get phone1
     *
     * @return string
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * Set phone2
     *
     * @param string $phone2
     *
     * @return User
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * Get phone2
     *
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
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
     * Set addressId
     *
     * @param integer $addressId
     *
     * @return User
     */
    public function setAddressId($addressId)
    {
        $this->address_id = $addressId;

        return $this;
    }

    /**
     * Get addressId
     *
     * @return integer
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * Set nip
     *
     * @param string $nip
     *
     * @return User
     */
    public function setNip($nip)
    {
        $this->nip = $nip;

        return $this;
    }

    /**
     * Get nip
     *
     * @return string
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * Set pesel
     *
     * @param string $pesel
     *
     * @return User
     */
    public function setPesel($pesel)
    {
        $this->pesel = $pesel;

        return $this;
    }

    /**
     * Get pesel
     *
     * @return string
     */
    public function getPesel()
    {
        return $this->pesel;
    }

    /**
     * Set bankAccountNumber
     *
     * @param string $bankAccountNumber
     *
     * @return User
     */
    public function setBankAccountNumber($bankAccountNumber)
    {
        $this->bank_account_number = $bankAccountNumber;

        return $this;
    }

    /**
     * Get bankAccountNumber
     *
     * @return string
     */
    public function getBankAccountNumber()
    {
        return $this->bank_account_number;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return User
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
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
     * Set removedAt
     *
     * @param \DateTime $removedAt
     *
     * @return User
     */
    public function setRemovedAt($removedAt)
    {
        $this->removed_at = $removedAt;

        return $this;
    }

    /**
     * Get removedAt
     *
     * @return \DateTime
     */
    public function getRemovedAt()
    {
        return $this->removed_at;
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
     * Set createdById
     *
     * @param integer $createdById
     *
     * @return User
     */
    public function setCreatedById($createdById)
    {
        $this->created_by_id = $createdById;

        return $this;
    }

    /**
     * Get createdById
     *
     * @return integer
     */
    public function getCreatedById()
    {
        return $this->created_by_id;
    }

    /**
     * Set updatedById
     *
     * @param integer $updatedById
     *
     * @return User
     */
    public function setUpdatedById($updatedById)
    {
        $this->updated_by_id = $updatedById;

        return $this;
    }

    /**
     * Get updatedById
     *
     * @return integer
     */
    public function getUpdatedById()
    {
        return $this->updated_by_id;
    }

    /**
     * Set removedById
     *
     * @param integer $removedById
     *
     * @return User
     */
    public function setRemovedById($removedById)
    {
        $this->removed_by_id = $removedById;

        return $this;
    }

    /**
     * Get removedById
     *
     * @return integer
     */
    public function getRemovedById()
    {
        return $this->removed_by_id;
    }

    /**
     * Set deletedById
     *
     * @param integer $deletedById
     *
     * @return User
     */
    public function setDeletedById($deletedById)
    {
        $this->deleted_by_id = $deletedById;

        return $this;
    }

    /**
     * Get deletedById
     *
     * @return integer
     */
    public function getDeletedById()
    {
        return $this->deleted_by_id;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return User
     */
    public function setAddress(\AppBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
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
        $workshop = $this->getCurrentWorkshop();
        $roles = [];
        /** @var UserRole $role */
        foreach($this->roles as $role)
        {
            if($role->getWorkshop() === $workshop)
            {
                $roles[] = $role->getRole();
            }
        }
        return $roles;
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
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return User
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set updatedBy
     *
     * @param \AppBundle\Entity\User $updatedBy
     *
     * @return User
     */
    public function setUpdatedBy(\AppBundle\Entity\User $updatedBy = null)
    {
        $this->updated_by = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set removedBy
     *
     * @param \AppBundle\Entity\User $removedBy
     *
     * @return User
     */
    public function setRemovedBy(\AppBundle\Entity\User $removedBy = null)
    {
        $this->removed_by = $removedBy;

        return $this;
    }

    /**
     * Get removedBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getRemovedBy()
    {
        return $this->removed_by;
    }

    /**
     * Set deletedBy
     *
     * @param \AppBundle\Entity\User $deletedBy
     *
     * @return User
     */
    public function setDeletedBy(\AppBundle\Entity\User $deletedBy = null)
    {
        $this->deleted_by = $deletedBy;

        return $this;
    }

    /**
     * Get deletedBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getDeletedBy()
    {
        return $this->deleted_by;
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

    /**
     * Add orderService
     *
     * @param \AppBundle\Entity\OrderService $orderService
     *
     * @return User
     */
    public function addOrderService(\AppBundle\Entity\OrderService $orderService)
    {
        $this->order_services[] = $orderService;

        return $this;
    }

    /**
     * Remove orderService
     *
     * @param \AppBundle\Entity\OrderService $orderService
     */
    public function removeOrderService(\AppBundle\Entity\OrderService $orderService)
    {
        $this->order_services->removeElement($orderService);
    }

    /**
     * Get orderServices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderServices()
    {
        return $this->order_services;
    }

    /**
     * Add orderAction
     *
     * @param \AppBundle\Entity\OrderAction $orderAction
     *
     * @return User
     */
    public function addOrderAction(\AppBundle\Entity\OrderAction $orderAction)
    {
        $this->order_actions[] = $orderAction;

        return $this;
    }

    /**
     * Remove orderAction
     *
     * @param \AppBundle\Entity\OrderAction $orderAction
     */
    public function removeOrderAction(\AppBundle\Entity\OrderAction $orderAction)
    {
        $this->order_actions->removeElement($orderAction);
    }

    /**
     * Get orderActions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderActions()
    {
        return $this->order_actions;
    }

    /**
     * Add position
     *
     * @param \AppBundle\Entity\Position $position
     *
     * @return User
     */
    public function addPosition(\AppBundle\Entity\Position $position)
    {
        $this->positions[] = $position;

        return $this;
    }

    /**
     * Remove position
     *
     * @param \AppBundle\Entity\Position $position
     */
    public function removePosition(\AppBundle\Entity\Position $position)
    {
        $this->positions->removeElement($position);
    }

    /**
     * Get positions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPositions()
    {
        return $this->positions;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials()
    {
    }
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }
}
