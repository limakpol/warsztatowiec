<?php

namespace AppBundle\Entity;

/**
 * Workman
 */
class Workman
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $workshop_id;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var string
     */
    private $hourly_rate_net;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $house_number;

    /**
     * @var string
     */
    private $flat_number;

    /**
     * @var string
     */
    private $post_code;

    /**
     * @var string
     */
    private $city;

    /**
     * @var integer
     */
    private $province_id;

    /**
     * @var string
     */
    private $phone2;

    /**
     * @var string
     */
    private $nip;

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
     * @var \AppBundle\Entity\Workshop
     */
    private $workshop;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    /**
     * @var \AppBundle\Entity\Province
     */
    private $province;

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
    private $order_services;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $order_actions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->order_services = new \Doctrine\Common\Collections\ArrayCollection();
        $this->order_actions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set workshopId
     *
     * @param integer $workshopId
     *
     * @return Workman
     */
    public function setWorkshopId($workshopId)
    {
        $this->workshop_id = $workshopId;

        return $this;
    }

    /**
     * Get workshopId
     *
     * @return integer
     */
    public function getWorkshopId()
    {
        return $this->workshop_id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Workman
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set hourlyRateNet
     *
     * @param string $hourlyRateNet
     *
     * @return Workman
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
     * Set street
     *
     * @param string $street
     *
     * @return Workman
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
     * @param string $houseNumber
     *
     * @return Workman
     */
    public function setHouseNumber($houseNumber)
    {
        $this->house_number = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->house_number;
    }

    /**
     * Set flatNumber
     *
     * @param string $flatNumber
     *
     * @return Workman
     */
    public function setFlatNumber($flatNumber)
    {
        $this->flat_number = $flatNumber;

        return $this;
    }

    /**
     * Get flatNumber
     *
     * @return string
     */
    public function getFlatNumber()
    {
        return $this->flat_number;
    }

    /**
     * Set postCode
     *
     * @param string $postCode
     *
     * @return Workman
     */
    public function setPostCode($postCode)
    {
        $this->post_code = $postCode;

        return $this;
    }

    /**
     * Get postCode
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->post_code;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Workman
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set provinceId
     *
     * @param integer $provinceId
     *
     * @return Workman
     */
    public function setProvinceId($provinceId)
    {
        $this->province_id = $provinceId;

        return $this;
    }

    /**
     * Get provinceId
     *
     * @return integer
     */
    public function getProvinceId()
    {
        return $this->province_id;
    }

    /**
     * Set phone2
     *
     * @param string $phone2
     *
     * @return Workman
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
     * Set nip
     *
     * @param string $nip
     *
     * @return Workman
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
     * Set bankAccountNumber
     *
     * @param string $bankAccountNumber
     *
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * Set workshop
     *
     * @param \AppBundle\Entity\Workshop $workshop
     *
     * @return Workman
     */
    public function setWorkshop(\AppBundle\Entity\Workshop $workshop = null)
    {
        $this->workshop = $workshop;

        return $this;
    }

    /**
     * Get workshop
     *
     * @return \AppBundle\Entity\Workshop
     */
    public function getWorkshop()
    {
        return $this->workshop;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Workman
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set province
     *
     * @param \AppBundle\Entity\Province $province
     *
     * @return Workman
     */
    public function setProvince(\AppBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \AppBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * @return Workman
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
     * Add orderService
     *
     * @param \AppBundle\Entity\OrderService $orderService
     *
     * @return Workman
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
     * @return Workman
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
}

