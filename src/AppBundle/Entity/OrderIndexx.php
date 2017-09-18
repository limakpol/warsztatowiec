<?php

namespace AppBundle\Entity;

/**
 * OrderIndexx
 */
class OrderIndexx
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $order_header_id;

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
    private $order_actions;

    /**
     * @var \AppBundle\Entity\OrderHeader
     */
    private $order_header;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $statuses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->order_actions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set orderHeaderId
     *
     * @param integer $orderHeaderId
     *
     * @return OrderIndexx
     */
    public function setOrderHeaderId($orderHeaderId)
    {
        $this->order_header_id = $orderHeaderId;

        return $this;
    }

    /**
     * Get orderHeaderId
     *
     * @return integer
     */
    public function getOrderHeaderId()
    {
        return $this->order_header_id;
    }

    /**
     * Set indexxId
     *
     * @param integer $indexxId
     *
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * Add orderAction
     *
     * @param \AppBundle\Entity\OrderAction $orderAction
     *
     * @return OrderIndexx
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
     * Set orderHeader
     *
     * @param \AppBundle\Entity\OrderHeader $orderHeader
     *
     * @return OrderIndexx
     */
    public function setOrderHeader(\AppBundle\Entity\OrderHeader $orderHeader = null)
    {
        $this->order_header = $orderHeader;

        return $this;
    }

    /**
     * Get orderHeader
     *
     * @return \AppBundle\Entity\OrderHeader
     */
    public function getOrderHeader()
    {
        return $this->order_header;
    }

    /**
     * Set indexx
     *
     * @param \AppBundle\Entity\Indexx $indexx
     *
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * @return OrderIndexx
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
     * Add status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return OrderIndexx
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
}

