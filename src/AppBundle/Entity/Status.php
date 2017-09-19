<?php

namespace AppBundle\Entity;

/**
 * Status
 */
class Status
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
    private $name;

    /**
     * @var string
     */
    private $hex_color;

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
    private $order_headers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $order_indexxes;

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
        $this->order_headers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->order_indexxes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Status
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
     * Set name
     *
     * @param string $name
     *
     * @return Status
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
     * Set hexColor
     *
     * @param string $hexColor
     *
     * @return Status
     */
    public function setHexColor($hexColor)
    {
        $this->hex_color = $hexColor;

        return $this;
    }

    /**
     * Get hexColor
     *
     * @return string
     */
    public function getHexColor()
    {
        return $this->hex_color;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * Add orderHeader
     *
     * @param \AppBundle\Entity\OrderHeader $orderHeader
     *
     * @return Status
     */
    public function addOrderHeader(\AppBundle\Entity\OrderHeader $orderHeader)
    {
        $this->order_headers[] = $orderHeader;

        return $this;
    }

    /**
     * Remove orderHeader
     *
     * @param \AppBundle\Entity\OrderHeader $orderHeader
     */
    public function removeOrderHeader(\AppBundle\Entity\OrderHeader $orderHeader)
    {
        $this->order_headers->removeElement($orderHeader);
    }

    /**
     * Get orderHeaders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderHeaders()
    {
        return $this->order_headers;
    }

    /**
     * Add orderIndexx
     *
     * @param \AppBundle\Entity\OrderIndexx $orderIndexx
     *
     * @return Status
     */
    public function addOrderIndexx(\AppBundle\Entity\OrderIndexx $orderIndexx)
    {
        $this->order_indexxes[] = $orderIndexx;

        return $this;
    }

    /**
     * Remove orderIndexx
     *
     * @param \AppBundle\Entity\OrderIndexx $orderIndexx
     */
    public function removeOrderIndexx(\AppBundle\Entity\OrderIndexx $orderIndexx)
    {
        $this->order_indexxes->removeElement($orderIndexx);
    }

    /**
     * Get orderIndexxes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderIndexxes()
    {
        return $this->order_indexxes;
    }

    /**
     * Add orderService
     *
     * @param \AppBundle\Entity\OrderService $orderService
     *
     * @return Status
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
     * @return Status
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
