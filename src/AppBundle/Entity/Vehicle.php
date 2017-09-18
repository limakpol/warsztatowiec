<?php

namespace AppBundle\Entity;

/**
 * Vehicle
 */
class Vehicle
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
    private $model_id;

    /**
     * @var string
     */
    private $registration_number;

    /**
     * @var string
     */
    private $vin;

    /**
     * @var integer
     */
    private $model_year;

    /**
     * @var integer
     */
    private $mileage;

    /**
     * @var string
     */
    private $engine_type;

    /**
     * @var string
     */
    private $engine_displacement_l;

    /**
     * @var integer
     */
    private $engine_displacement_cm3;

    /**
     * @var integer
     */
    private $engine_power_km;

    /**
     * @var integer
     */
    private $engine_power_kw;

    /**
     * @var \DateTime
     */
    private $date_of_inspection;

    /**
     * @var \DateTime
     */
    private $date_of_oil_change;

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
     * @var \AppBundle\Entity\Model
     */
    private $model;

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
    private $customers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->customers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Vehicle
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
     * Set modelId
     *
     * @param integer $modelId
     *
     * @return Vehicle
     */
    public function setModelId($modelId)
    {
        $this->model_id = $modelId;

        return $this;
    }

    /**
     * Get modelId
     *
     * @return integer
     */
    public function getModelId()
    {
        return $this->model_id;
    }

    /**
     * Set registrationNumber
     *
     * @param string $registrationNumber
     *
     * @return Vehicle
     */
    public function setRegistrationNumber($registrationNumber)
    {
        $this->registration_number = $registrationNumber;

        return $this;
    }

    /**
     * Get registrationNumber
     *
     * @return string
     */
    public function getRegistrationNumber()
    {
        return $this->registration_number;
    }

    /**
     * Set vin
     *
     * @param string $vin
     *
     * @return Vehicle
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set modelYear
     *
     * @param integer $modelYear
     *
     * @return Vehicle
     */
    public function setModelYear($modelYear)
    {
        $this->model_year = $modelYear;

        return $this;
    }

    /**
     * Get modelYear
     *
     * @return integer
     */
    public function getModelYear()
    {
        return $this->model_year;
    }

    /**
     * Set mileage
     *
     * @param integer $mileage
     *
     * @return Vehicle
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return integer
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set engineType
     *
     * @param string $engineType
     *
     * @return Vehicle
     */
    public function setEngineType($engineType)
    {
        $this->engine_type = $engineType;

        return $this;
    }

    /**
     * Get engineType
     *
     * @return string
     */
    public function getEngineType()
    {
        return $this->engine_type;
    }

    /**
     * Set engineDisplacementL
     *
     * @param string $engineDisplacementL
     *
     * @return Vehicle
     */
    public function setEngineDisplacementL($engineDisplacementL)
    {
        $this->engine_displacement_l = $engineDisplacementL;

        return $this;
    }

    /**
     * Get engineDisplacementL
     *
     * @return string
     */
    public function getEngineDisplacementL()
    {
        return $this->engine_displacement_l;
    }

    /**
     * Set engineDisplacementCm3
     *
     * @param integer $engineDisplacementCm3
     *
     * @return Vehicle
     */
    public function setEngineDisplacementCm3($engineDisplacementCm3)
    {
        $this->engine_displacement_cm3 = $engineDisplacementCm3;

        return $this;
    }

    /**
     * Get engineDisplacementCm3
     *
     * @return integer
     */
    public function getEngineDisplacementCm3()
    {
        return $this->engine_displacement_cm3;
    }

    /**
     * Set enginePowerKm
     *
     * @param integer $enginePowerKm
     *
     * @return Vehicle
     */
    public function setEnginePowerKm($enginePowerKm)
    {
        $this->engine_power_km = $enginePowerKm;

        return $this;
    }

    /**
     * Get enginePowerKm
     *
     * @return integer
     */
    public function getEnginePowerKm()
    {
        return $this->engine_power_km;
    }

    /**
     * Set enginePowerKw
     *
     * @param integer $enginePowerKw
     *
     * @return Vehicle
     */
    public function setEnginePowerKw($enginePowerKw)
    {
        $this->engine_power_kw = $enginePowerKw;

        return $this;
    }

    /**
     * Get enginePowerKw
     *
     * @return integer
     */
    public function getEnginePowerKw()
    {
        return $this->engine_power_kw;
    }

    /**
     * Set dateOfInspection
     *
     * @param \DateTime $dateOfInspection
     *
     * @return Vehicle
     */
    public function setDateOfInspection($dateOfInspection)
    {
        $this->date_of_inspection = $dateOfInspection;

        return $this;
    }

    /**
     * Get dateOfInspection
     *
     * @return \DateTime
     */
    public function getDateOfInspection()
    {
        return $this->date_of_inspection;
    }

    /**
     * Set dateOfOilChange
     *
     * @param \DateTime $dateOfOilChange
     *
     * @return Vehicle
     */
    public function setDateOfOilChange($dateOfOilChange)
    {
        $this->date_of_oil_change = $dateOfOilChange;

        return $this;
    }

    /**
     * Get dateOfOilChange
     *
     * @return \DateTime
     */
    public function getDateOfOilChange()
    {
        return $this->date_of_oil_change;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * Set model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Vehicle
     */
    public function setModel(\AppBundle\Entity\Model $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \AppBundle\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * @return Vehicle
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
     * Add customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Vehicle
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
}

