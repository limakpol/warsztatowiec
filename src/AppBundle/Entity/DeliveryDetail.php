<?php

namespace AppBundle\Entity;

/**
 * DeliveryDetail
 */
class DeliveryDetail
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $delivery_header_id;

    /**
     * @var integer
     */
    private $indexx_id;

    /**
     * @var string
     */
    private $unit_price_net = 0.0;

    /**
     * @var string
     */
    private $quantity = 0.0;

    /**
     * @var string
     */
    private $total_net_before_discount = 0.0;

    /**
     * @var integer
     */
    private $discount_pc = 0;

    /**
     * @var string
     */
    private $discount = 0.0;

    /**
     * @var string
     */
    private $total_net = 0.0;

    /**
     * @var integer
     */
    private $vat_pc = 0;

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
     * @var \AppBundle\Entity\DeliveryHeader
     */
    private $delivery_header;

    /**
     * @var \AppBundle\Entity\Indexx
     */
    private $indexx;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set deliveryHeaderId
     *
     * @param integer $deliveryHeaderId
     *
     * @return DeliveryDetail
     */
    public function setDeliveryHeaderId($deliveryHeaderId)
    {
        $this->delivery_header_id = $deliveryHeaderId;

        return $this;
    }

    /**
     * Get deliveryHeaderId
     *
     * @return integer
     */
    public function getDeliveryHeaderId()
    {
        return $this->delivery_header_id;
    }

    /**
     * Set indexxId
     *
     * @param integer $indexxId
     *
     * @return DeliveryDetail
     */
    public function setIndexxId($indexxId)
    {
        $this->indexx_id = $indexxId;

        return $this;
    }

    /**
     * Get indexxId
     *
     * @return integer
     */
    public function getIndexxId()
    {
        return $this->indexx_id;
    }

    /**
     * Set unitPriceNet
     *
     * @param string $unitPriceNet
     *
     * @return DeliveryDetail
     */
    public function setUnitPriceNet($unitPriceNet)
    {
        $this->unit_price_net = $unitPriceNet;

        return $this;
    }

    /**
     * Get unitPriceNet
     *
     * @return string
     */
    public function getUnitPriceNet()
    {
        return $this->unit_price_net;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     *
     * @return DeliveryDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set totalNetBeforeDiscount
     *
     * @param string $totalNetBeforeDiscount
     *
     * @return DeliveryDetail
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
     * Set discountPc
     *
     * @param integer $discountPc
     *
     * @return DeliveryDetail
     */
    public function setDiscountPc($discountPc)
    {
        $this->discount_pc = $discountPc;

        return $this;
    }

    /**
     * Get discountPc
     *
     * @return integer
     */
    public function getDiscountPc()
    {
        return $this->discount_pc;
    }

    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * Set vatPc
     *
     * @param integer $vatPc
     *
     * @return DeliveryDetail
     */
    public function setVatPc($vatPc)
    {
        $this->vat_pc = $vatPc;

        return $this;
    }

    /**
     * Get vatPc
     *
     * @return integer
     */
    public function getVatPc()
    {
        return $this->vat_pc;
    }

    /**
     * Set vat
     *
     * @param string $vat
     *
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * Set deliveryHeader
     *
     * @param \AppBundle\Entity\DeliveryHeader $deliveryHeader
     *
     * @return DeliveryDetail
     */
    public function setDeliveryHeader(\AppBundle\Entity\DeliveryHeader $deliveryHeader = null)
    {
        $this->delivery_header = $deliveryHeader;

        return $this;
    }

    /**
     * Get deliveryHeader
     *
     * @return \AppBundle\Entity\DeliveryHeader
     */
    public function getDeliveryHeader()
    {
        return $this->delivery_header;
    }

    /**
     * Set indexx
     *
     * @param \AppBundle\Entity\Indexx $indexx
     *
     * @return DeliveryDetail
     */
    public function setIndexx(\AppBundle\Entity\Indexx $indexx = null)
    {
        $this->indexx = $indexx;

        return $this;
    }

    /**
     * Get indexx
     *
     * @return \AppBundle\Entity\Indexx
     */
    public function getIndexx()
    {
        return $this->indexx;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
     * @return DeliveryDetail
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
