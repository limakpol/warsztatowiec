<?php

namespace AppBundle\Entity;

/**
 * OrderHeader
 */
class OrderHeader
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
     * @var integer
     */
    private $vehicle_id;

    /**
     * @var integer
     */
    private $number_monthly;

    /**
     * @var integer
     */
    private $number_yearly;

    /**
     * @var boolean
     */
    private $priority = 0;

    /**
     * @var integer
     */
    private $workstation_id;

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
     * @var string
     */
    private $remarks;

    /**
     * @var string
     */
    private $amount_paid = 0.0;

    /**
     * @var \DateTime
     */
    private $paid_at;

    /**
     * @var \DateTime
     */
    private $completed_at;

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
    private $symptoms;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $faults;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $order_indexxes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $order_services;

    /**
     * @var \AppBundle\Entity\Workshop
     */
    private $workshop;

    /**
     * @var \AppBundle\Entity\Customer
     */
    private $customer;

    /**
     * @var \AppBundle\Entity\Vehicle
     */
    private $vehicle;

    /**
     * @var \AppBundle\Entity\Workstation
     */
    private $workstation;

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
        $this->symptoms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->faults = new \Doctrine\Common\Collections\ArrayCollection();
        $this->order_indexxes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->order_services = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set workshopId
     *
     * @param integer $workshopId
     *
     * @return OrderHeader
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
     * @return OrderHeader
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
     * Set vehicleId
     *
     * @param integer $vehicleId
     *
     * @return OrderHeader
     */
    public function setVehicleId($vehicleId)
    {
        $this->vehicle_id = $vehicleId;

        return $this;
    }

    /**
     * Get vehicleId
     *
     * @return integer
     */
    public function getVehicleId()
    {
        return $this->vehicle_id;
    }

    /**
     * Set numberMonthly
     *
     * @param integer $numberMonthly
     *
     * @return OrderHeader
     */
    public function setNumberMonthly($numberMonthly)
    {
        $this->number_monthly = $numberMonthly;

        return $this;
    }

    /**
     * Get numberMonthly
     *
     * @return integer
     */
    public function getNumberMonthly()
    {
        return $this->number_monthly;
    }

    /**
     * Set numberYearly
     *
     * @param integer $numberYearly
     *
     * @return OrderHeader
     */
    public function setNumberYearly($numberYearly)
    {
        $this->number_yearly = $numberYearly;

        return $this;
    }

    /**
     * Get numberYearly
     *
     * @return integer
     */
    public function getNumberYearly()
    {
        return $this->number_yearly;
    }

    /**
     * Set priority
     *
     * @param boolean $priority
     *
     * @return OrderHeader
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return boolean
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set workstationId
     *
     * @param integer $workstationId
     *
     * @return OrderHeader
     */
    public function setWorkstationId($workstationId)
    {
        $this->workstation_id = $workstationId;

        return $this;
    }

    /**
     * Get workstationId
     *
     * @return integer
     */
    public function getWorkstationId()
    {
        return $this->workstation_id;
    }

    /**
     * Set totalNetBeforeDiscount
     *
     * @param string $totalNetBeforeDiscount
     *
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * Set amountPaid
     *
     * @param string $amountPaid
     *
     * @return OrderHeader
     */
    public function setAmountPaid($amountPaid)
    {
        $this->amount_paid = $amountPaid;

        return $this;
    }

    /**
     * Get amountPaid
     *
     * @return string
     */
    public function getAmountPaid()
    {
        return $this->amount_paid;
    }

    /**
     * Set paidAt
     *
     * @param \DateTime $paidAt
     *
     * @return OrderHeader
     */
    public function setPaidAt($paidAt)
    {
        $this->paid_at = $paidAt;

        return $this;
    }

    /**
     * Get paidAt
     *
     * @return \DateTime
     */
    public function getPaidAt()
    {
        return $this->paid_at;
    }

    /**
     * Set completedAt
     *
     * @param \DateTime $completedAt
     *
     * @return OrderHeader
     */
    public function setCompletedAt($completedAt)
    {
        $this->completed_at = $completedAt;

        return $this;
    }

    /**
     * Get completedAt
     *
     * @return \DateTime
     */
    public function getCompletedAt()
    {
        return $this->completed_at;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * Add symptom
     *
     * @param \AppBundle\Entity\OrderSymptom $symptom
     *
     * @return OrderHeader
     */
    public function addSymptom(\AppBundle\Entity\OrderSymptom $symptom)
    {
        $this->symptoms[] = $symptom;

        return $this;
    }

    /**
     * Remove symptom
     *
     * @param \AppBundle\Entity\OrderSymptom $symptom
     */
    public function removeSymptom(\AppBundle\Entity\OrderSymptom $symptom)
    {
        $this->symptoms->removeElement($symptom);
    }

    /**
     * Get symptoms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSymptoms()
    {
        return $this->symptoms;
    }

    /**
     * Add fault
     *
     * @param \AppBundle\Entity\OrderFault $fault
     *
     * @return OrderHeader
     */
    public function addFault(\AppBundle\Entity\OrderFault $fault)
    {
        $this->faults[] = $fault;

        return $this;
    }

    /**
     * Remove fault
     *
     * @param \AppBundle\Entity\OrderFault $fault
     */
    public function removeFault(\AppBundle\Entity\OrderFault $fault)
    {
        $this->faults->removeElement($fault);
    }

    /**
     * Get faults
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFaults()
    {
        return $this->faults;
    }

    /**
     * Add orderIndexx
     *
     * @param \AppBundle\Entity\OrderIndexx $orderIndexx
     *
     * @return OrderHeader
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
     * @return OrderHeader
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
     * Set workshop
     *
     * @param \AppBundle\Entity\Workshop $workshop
     *
     * @return OrderHeader
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
     * @return OrderHeader
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
     * Set vehicle
     *
     * @param \AppBundle\Entity\Vehicle $vehicle
     *
     * @return OrderHeader
     */
    public function setVehicle(\AppBundle\Entity\Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \AppBundle\Entity\Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set workstation
     *
     * @param \AppBundle\Entity\Workstation $workstation
     *
     * @return OrderHeader
     */
    public function setWorkstation(\AppBundle\Entity\Workstation $workstation = null)
    {
        $this->workstation = $workstation;

        return $this;
    }

    /**
     * Get workstation
     *
     * @return \AppBundle\Entity\Workstation
     */
    public function getWorkstation()
    {
        return $this->workstation;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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
     * @return OrderHeader
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

