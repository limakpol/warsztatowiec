<?php

namespace AppBundle\Entity;

/**
 * Customer
 */
class Customer
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
    private $company_name;

    /**
     * @var boolean
     */
    private $is_customer = 1;

    /**
     * @var boolean
     */
    private $is_supplier = 0;

    /**
     * @var boolean
     */
    private $is_recipient = 0;

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
    private $mobile_phone1;

    /**
     * @var string
     */
    private $mobile_phone2;

    /**
     * @var string
     */
    private $landline_phone;

    /**
     * @var string
     */
    private $email;

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
    private $contact_person;

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
    private $deleted_at;

    /**
     * @var \AppBundle\Entity\Workshop
     */
    private $workshop;

    /**
     * @var \AppBundle\Entity\Province
     */
    private $province;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $vehicles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $groups;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vehicles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Customer
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
     * Set forename
     *
     * @param string $forename
     *
     * @return Customer
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
     * @return Customer
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
     * Set companyName
     *
     * @param string $companyName
     *
     * @return Customer
     */
    public function setCompanyName($companyName)
    {
        $this->company_name = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Set isCustomer
     *
     * @param boolean $isCustomer
     *
     * @return Customer
     */
    public function setIsCustomer($isCustomer)
    {
        $this->is_customer = $isCustomer;

        return $this;
    }

    /**
     * Get isCustomer
     *
     * @return boolean
     */
    public function getIsCustomer()
    {
        return $this->is_customer;
    }

    /**
     * Set isSupplier
     *
     * @param boolean $isSupplier
     *
     * @return Customer
     */
    public function setIsSupplier($isSupplier)
    {
        $this->is_supplier = $isSupplier;

        return $this;
    }

    /**
     * Get isSupplier
     *
     * @return boolean
     */
    public function getIsSupplier()
    {
        return $this->is_supplier;
    }

    /**
     * Set isRecipient
     *
     * @param boolean $isRecipient
     *
     * @return Customer
     */
    public function setIsRecipient($isRecipient)
    {
        $this->is_recipient = $isRecipient;

        return $this;
    }

    /**
     * Get isRecipient
     *
     * @return boolean
     */
    public function getIsRecipient()
    {
        return $this->is_recipient;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * Set mobilePhone1
     *
     * @param string $mobilePhone1
     *
     * @return Customer
     */
    public function setMobilePhone1($mobilePhone1)
    {
        $this->mobile_phone1 = $mobilePhone1;

        return $this;
    }

    /**
     * Get mobilePhone1
     *
     * @return string
     */
    public function getMobilePhone1()
    {
        return $this->mobile_phone1;
    }

    /**
     * Set mobilePhone2
     *
     * @param string $mobilePhone2
     *
     * @return Customer
     */
    public function setMobilePhone2($mobilePhone2)
    {
        $this->mobile_phone2 = $mobilePhone2;

        return $this;
    }

    /**
     * Get mobilePhone2
     *
     * @return string
     */
    public function getMobilePhone2()
    {
        return $this->mobile_phone2;
    }

    /**
     * Set landlinePhone
     *
     * @param string $landlinePhone
     *
     * @return Customer
     */
    public function setLandlinePhone($landlinePhone)
    {
        $this->landline_phone = $landlinePhone;

        return $this;
    }

    /**
     * Get landlinePhone
     *
     * @return string
     */
    public function getLandlinePhone()
    {
        return $this->landline_phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customer
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
     * Set nip
     *
     * @param string $nip
     *
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * Set contactPerson
     *
     * @param string $contactPerson
     *
     * @return Customer
     */
    public function setContactPerson($contactPerson)
    {
        $this->contact_person = $contactPerson;

        return $this;
    }

    /**
     * Get contactPerson
     *
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contact_person;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * Set workshop
     *
     * @param \AppBundle\Entity\Workshop $workshop
     *
     * @return Customer
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
     * Set province
     *
     * @param \AppBundle\Entity\Province $province
     *
     * @return Customer
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
     * Add vehicle
     *
     * @param \AppBundle\Entity\Vehicle $vehicle
     *
     * @return Customer
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
     * Add group
     *
     * @param \AppBundle\Entity\Group $group
     *
     * @return Customer
     */
    public function addGroup(\AppBundle\Entity\Group $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \AppBundle\Entity\Group $group
     */
    public function removeGroup(\AppBundle\Entity\Group $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
