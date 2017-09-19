<?php

namespace AppBundle\Entity;

/**
 * IndexxEdit
 */
class IndexxEdit
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
    private $indexx_id;

    /**
     * @var string
     */
    private $before_qty = 0.0;

    /**
     * @var string
     */
    private $after_qty = 0.0;

    /**
     * @var string
     */
    private $change_qty = 0.0;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var integer
     */
    private $created_by_id;

    /**
     * @var \AppBundle\Entity\Workshop
     */
    private $workshop;

    /**
     * @var \AppBundle\Entity\Indexx
     */
    private $indexx;

    /**
     * @var \AppBundle\Entity\User
     */
    private $created_by;


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
     * @return IndexxEdit
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
     * Set indexxId
     *
     * @param integer $indexxId
     *
     * @return IndexxEdit
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
     * Set beforeQty
     *
     * @param string $beforeQty
     *
     * @return IndexxEdit
     */
    public function setBeforeQty($beforeQty)
    {
        $this->before_qty = $beforeQty;

        return $this;
    }

    /**
     * Get beforeQty
     *
     * @return string
     */
    public function getBeforeQty()
    {
        return $this->before_qty;
    }

    /**
     * Set afterQty
     *
     * @param string $afterQty
     *
     * @return IndexxEdit
     */
    public function setAfterQty($afterQty)
    {
        $this->after_qty = $afterQty;

        return $this;
    }

    /**
     * Get afterQty
     *
     * @return string
     */
    public function getAfterQty()
    {
        return $this->after_qty;
    }

    /**
     * Set changeQty
     *
     * @param string $changeQty
     *
     * @return IndexxEdit
     */
    public function setChangeQty($changeQty)
    {
        $this->change_qty = $changeQty;

        return $this;
    }

    /**
     * Get changeQty
     *
     * @return string
     */
    public function getChangeQty()
    {
        return $this->change_qty;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return IndexxEdit
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
     * Set createdById
     *
     * @param integer $createdById
     *
     * @return IndexxEdit
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
     * Set workshop
     *
     * @param \AppBundle\Entity\Workshop $workshop
     *
     * @return IndexxEdit
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
     * Set indexx
     *
     * @param \AppBundle\Entity\Indexx $indexx
     *
     * @return IndexxEdit
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
     * @return IndexxEdit
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
}
