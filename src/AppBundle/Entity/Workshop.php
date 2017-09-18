<?php

namespace AppBundle\Entity;

/**
 * Workshop
 */
class Workshop
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $owner_user_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $subscription_expiration_date;

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
    private $bank_account_number;

    /**
     * @var string
     */
    private $website_url;

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
     * @var \AppBundle\Entity\Parameters
     */
    private $parameters;

    /**
     * @var \AppBundle\Entity\Settings
     */
    private $settings;

    /**
     * @var \AppBundle\Entity\Address
     */
    private $address;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $workstations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $models;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $vehicles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $customers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $goods;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $measures;

    /**
     * @var \AppBundle\Entity\User
     */
    private $owner_user;

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
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workstations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->models = new \Doctrine\Common\Collections\ArrayCollection();
        $this->vehicles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->customers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->goods = new \Doctrine\Common\Collections\ArrayCollection();
        $this->measures = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set ownerUserId
     *
     * @param integer $ownerUserId
     *
     * @return Workshop
     */
    public function setOwnerUserId($ownerUserId)
    {
        $this->owner_user_id = $ownerUserId;

        return $this;
    }

    /**
     * Get ownerUserId
     *
     * @return integer
     */
    public function getOwnerUserId()
    {
        return $this->owner_user_id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Workshop
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
     * Set phone
     *
     * @param string $phone
     *
     * @return Workshop
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
     * @return Workshop
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
     * Set subscriptionExpirationDate
     *
     * @param \DateTime $subscriptionExpirationDate
     *
     * @return Workshop
     */
    public function setSubscriptionExpirationDate($subscriptionExpirationDate)
    {
        $this->subscription_expiration_date = $subscriptionExpirationDate;

        return $this;
    }

    /**
     * Get subscriptionExpirationDate
     *
     * @return \DateTime
     */
    public function getSubscriptionExpirationDate()
    {
        return $this->subscription_expiration_date;
    }

    /**
     * Set addressId
     *
     * @param integer $addressId
     *
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * Set websiteUrl
     *
     * @param string $websiteUrl
     *
     * @return Workshop
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->website_url = $websiteUrl;

        return $this;
    }

    /**
     * Get websiteUrl
     *
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->website_url;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * Set parameters
     *
     * @param \AppBundle\Entity\Parameters $parameters
     *
     * @return Workshop
     */
    public function setParameters(\AppBundle\Entity\Parameters $parameters = null)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return \AppBundle\Entity\Parameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set settings
     *
     * @param \AppBundle\Entity\Settings $settings
     *
     * @return Workshop
     */
    public function setSettings(\AppBundle\Entity\Settings $settings = null)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return \AppBundle\Entity\Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return Workshop
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
     * Add workstation
     *
     * @param \AppBundle\Entity\Workstation $workstation
     *
     * @return Workshop
     */
    public function addWorkstation(\AppBundle\Entity\Workstation $workstation)
    {
        $this->workstations[] = $workstation;

        return $this;
    }

    /**
     * Remove workstation
     *
     * @param \AppBundle\Entity\Workstation $workstation
     */
    public function removeWorkstation(\AppBundle\Entity\Workstation $workstation)
    {
        $this->workstations->removeElement($workstation);
    }

    /**
     * Get workstations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkstations()
    {
        return $this->workstations;
    }

    /**
     * Add model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Workshop
     */
    public function addModel(\AppBundle\Entity\Model $model)
    {
        $this->models[] = $model;

        return $this;
    }

    /**
     * Remove model
     *
     * @param \AppBundle\Entity\Model $model
     */
    public function removeModel(\AppBundle\Entity\Model $model)
    {
        $this->models->removeElement($model);
    }

    /**
     * Get models
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * Add vehicle
     *
     * @param \AppBundle\Entity\Vehicle $vehicle
     *
     * @return Workshop
     */
    public function addVehicle(\AppBundle\Entity\Vehicle $vehicle)
    {
        $this->vehicles[] = $vehicle;

        return $this;
    }

    /**
     * Remove vehicle
     *
     * @param \AppBundle\Entity\Vehicle $vehicle
     */
    public function removeVehicle(\AppBundle\Entity\Vehicle $vehicle)
    {
        $this->vehicles->removeElement($vehicle);
    }

    /**
     * Get vehicles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }

    /**
     * Add customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Workshop
     */
    public function addCustomer(\AppBundle\Entity\Customer $customer)
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * Remove customer
     *
     * @param \AppBundle\Entity\Customer $customer
     */
    public function removeCustomer(\AppBundle\Entity\Customer $customer)
    {
        $this->customers->removeElement($customer);
    }

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * Add good
     *
     * @param \AppBundle\Entity\Good $good
     *
     * @return Workshop
     */
    public function addGood(\AppBundle\Entity\Good $good)
    {
        $this->goods[] = $good;

        return $this;
    }

    /**
     * Remove good
     *
     * @param \AppBundle\Entity\Good $good
     */
    public function removeGood(\AppBundle\Entity\Good $good)
    {
        $this->goods->removeElement($good);
    }

    /**
     * Get goods
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGoods()
    {
        return $this->goods;
    }

    /**
     * Add measure
     *
     * @param \AppBundle\Entity\Measure $measure
     *
     * @return Workshop
     */
    public function addMeasure(\AppBundle\Entity\Measure $measure)
    {
        $this->measures[] = $measure;

        return $this;
    }

    /**
     * Remove measure
     *
     * @param \AppBundle\Entity\Measure $measure
     */
    public function removeMeasure(\AppBundle\Entity\Measure $measure)
    {
        $this->measures->removeElement($measure);
    }

    /**
     * Get measures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeasures()
    {
        return $this->measures;
    }

    /**
     * Set ownerUser
     *
     * @param \AppBundle\Entity\User $ownerUser
     *
     * @return Workshop
     */
    public function setOwnerUser(\AppBundle\Entity\User $ownerUser = null)
    {
        $this->owner_user = $ownerUser;

        return $this;
    }

    /**
     * Get ownerUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getOwnerUser()
    {
        return $this->owner_user;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * @return Workshop
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
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Workshop
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}

