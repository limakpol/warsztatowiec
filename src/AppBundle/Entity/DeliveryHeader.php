<?php

namespace AppBundle\Entity;

/**
 * DeliveryHeader
 */
class DeliveryHeader
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
    private $customer_id;

    /**
     * @var string
     */
    private $document_type;

    /**
     * @var string
     */
    private $document_number;

    /**
     * @var string
     */
    private $total_net_before_discount = 0.0;

    /**
     * @var string
     */
    private $discount = 0.0;

    /**
     * @var string
     */
    private $total_net = 0.0;

    /**
     * @var string
     */
    private $vat = 0.0;

    /**
     * @var string
     */
    private $total_due = 0.0;

    /**
     * @var boolean
     */
    private $autocomplete = 1;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $delivery_details;

    /**
     * @var \AppBundle\Entity\Workshop
     */
    private $workshop;

    /**
     * @var \AppBundle\Entity\Customer
     */
    private $customer;

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
     * Constructor
     */
    public function __construct()
    {
        $this->delivery_details = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return DeliveryHeader
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
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return DeliveryHeader
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set documentType
     *
     * @param string $documentType
     *
     * @return DeliveryHeader
     */
    public function setDocumentType($documentType)
    {
        $this->document_type = $documentType;

        return $this;
    }

    /**
     * Get documentType
     *
     * @return string
     */
    public function getDocumentType()
    {
        return $this->document_type;
    }

    /**
     * Set documentNumber
     *
     * @param string $documentNumber
     *
     * @return DeliveryHeader
     */
    public function setDocumentNumber($documentNumber)
    {
        $this->document_number = $documentNumber;

        return $this;
    }

    /**
     * Get documentNumber
     *
     * @return string
     */
    public function getDocumentNumber()
    {
        return $this->document_number;
    }

    /**
     * Set totalNetBeforeDiscount
     *
     * @param string $totalNetBeforeDiscount
     *
     * @return DeliveryHeader
     */
    public function setTotalNetBeforeDiscount($totalNetBeforeDiscount)
    {
        $this->total_net_before_discount = $totalNetBeforeDiscount;

        return $this;
    }

    /**
     * Get totalNetBeforeDiscount
     *
     * @return string
     */
    public function getTotalNetBeforeDiscount()
    {
        return $this->total_net_before_discount;
    }

    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return DeliveryHeader
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set totalNet
     *
     * @param string $totalNet
     *
     * @return DeliveryHeader
     */
    public function setTotalNet($totalNet)
    {
        $this->total_net = $totalNet;

        return $this;
    }

    /**
     * Get totalNet
     *
     * @return string
     */
    public function getTotalNet()
    {
        return $this->total_net;
    }

    /**
     * Set vat
     *
     * @param string $vat
     *
     * @return DeliveryHeader
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Get vat
     *
     * @return string
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Set totalDue
     *
     * @param string $totalDue
     *
     * @return DeliveryHeader
     */
    public function setTotalDue($totalDue)
    {
        $this->total_due = $totalDue;

        return $this;
    }

    /**
     * Get totalDue
     *
     * @return string
     */
    public function getTotalDue()
    {
        return $this->total_due;
    }

    /**
     * Set autocomplete
     *
     * @param boolean $autocomplete
     *
     * @return DeliveryHeader
     */
    public function setAutocomplete($autocomplete)
    {
        $this->autocomplete = $autocomplete;

        return $this;
    }

    /**
     * Get autocomplete
     *
     * @return boolean
     */
    public function getAutocomplete()
    {
        return $this->autocomplete;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * Add deliveryDetail
     *
     * @param \AppBundle\Entity\DeliveryDetail $deliveryDetail
     *
     * @return DeliveryHeader
     */
    public function addDeliveryDetail(\AppBundle\Entity\DeliveryDetail $deliveryDetail)
    {
        $this->delivery_details[] = $deliveryDetail;

        return $this;
    }

    /**
     * Remove deliveryDetail
     *
     * @param \AppBundle\Entity\DeliveryDetail $deliveryDetail
     */
    public function removeDeliveryDetail(\AppBundle\Entity\DeliveryDetail $deliveryDetail)
    {
        $this->delivery_details->removeElement($deliveryDetail);
    }

    /**
     * Get deliveryDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeliveryDetails()
    {
        return $this->delivery_details;
    }

    /**
     * Set workshop
     *
     * @param \AppBundle\Entity\Workshop $workshop
     *
     * @return DeliveryHeader
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
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return DeliveryHeader
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
     * @return DeliveryHeader
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
}
