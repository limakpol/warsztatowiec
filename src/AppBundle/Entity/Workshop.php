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
    private $deleted_at;

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
     * @var \AppBundle\Entity\User
     */
    private $owner_user;

    /**
     * @var \AppBundle\Entity\Province
     */
    private $province;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set province
     *
     * @param \AppBundle\Entity\Province $province
     *
     * @return Workshop
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

