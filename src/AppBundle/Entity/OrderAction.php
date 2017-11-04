<?php

namespace AppBundle\Entity;

/**
 * OrderAction
 */
class OrderAction
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $action_id;

    /**
     * @var integer
     */
    private $order_indexx_id;

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
     * @var \AppBundle\Entity\Action
     */
    private $action;

    /**
     * @var \AppBundle\Entity\OrderIndexx
     */
    private $order_indexx;

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
    private $workmans;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $statuses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workmans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->statuses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set actionId
     *
     * @param integer $actionId
     *
     * @return OrderAction
     */
    public function setActionId($actionId)
    {
        $this->action_id = $actionId;

        return $this;
    }

    /**
     * Get actionId
     *
     * @return integer
     */
    public function getActionId()
    {
        return $this->action_id;
    }

    /**
     * Set orderIndexxId
     *
     * @param integer $orderIndexxId
     *
     * @return OrderAction
     */
    public function setOrderIndexxId($orderIndexxId)
    {
        $this->order_indexx_id = $orderIndexxId;

        return $this;
    }

    /**
     * Get orderIndexxId
     *
     * @return integer
     */
    public function getOrderIndexxId()
    {
        return $this->order_indexx_id;
    }

    /**
     * Set unitPriceNet
     *
     * @param string $unitPriceNet
     *
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * Set remarks
     *
     * @param string $remarks
     *
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * Set action
     *
     * @param \AppBundle\Entity\Action $action
     *
     * @return OrderAction
     */
    public function setAction(\AppBundle\Entity\Action $action = null)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \AppBundle\Entity\Action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set orderIndexx
     *
     * @param \AppBundle\Entity\OrderIndexx $orderIndexx
     *
     * @return OrderAction
     */
    public function setOrderIndexx(\AppBundle\Entity\OrderIndexx $orderIndexx = null)
    {
        $this->order_indexx = $orderIndexx;

        return $this;
    }

    /**
     * Get orderIndexx
     *
     * @return \AppBundle\Entity\OrderIndexx
     */
    public function getOrderIndexx()
    {
        return $this->order_indexx;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * @return OrderAction
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
     * Add workman
     *
     * @param \AppBundle\Entity\User $workman
     *
     * @return OrderAction
     */
    public function addWorkman(\AppBundle\Entity\User $workman)
    {
        $this->workmans[] = $workman;

        return $this;
    }

    /**
     * Remove workman
     *
     * @param \AppBundle\Entity\User $workman
     */
    public function removeWorkman(\AppBundle\Entity\User $workman)
    {
        $this->workmans->removeElement($workman);
    }

    /**
     * Get workmans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkmans()
    {
        return $this->workmans;
    }

    /**
     * Add status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return OrderAction
     */
    public function addStatus(\AppBundle\Entity\Status $status)
    {
        $this->statuses[] = $status;

        return $this;
    }

    /**
     * Remove status
     *
     * @param \AppBundle\Entity\Status $status
     */
    public function removeStatus(\AppBundle\Entity\Status $status)
    {
        $this->statuses->removeElement($status);
    }

    /**
     * Get statuses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStatuses()
    {
        return $this->statuses;
    }
    /**
     * @var integer
     */
    private $measure_id;

    /**
     * @var \AppBundle\Entity\Measure
     */
    private $measure;


    /**
     * Set measureId
     *
     * @param integer $measureId
     *
     * @return OrderAction
     */
    public function setMeasureId($measureId)
    {
        $this->measure_id = $measureId;

        return $this;
    }

    /**
     * Get measureId
     *
     * @return integer
     */
    public function getMeasureId()
    {
        return $this->measure_id;
    }

    /**
     * Set measure
     *
     * @param \AppBundle\Entity\Measure $measure
     *
     * @return OrderAction
     */
    public function setMeasure(\AppBundle\Entity\Measure $measure = null)
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get measure
     *
     * @return \AppBundle\Entity\Measure
     */
    public function getMeasure()
    {
        return $this->measure;
    }
}
