<?php

namespace AppBundle\Entity;

/**
 * Parameters
 */
class Parameters
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
    private $good_margin_pc = 30;

    /**
     * @var integer
     */
    private $good_vat_pc = 23;

    /**
     * @var integer
     */
    private $service_vat_pc = 23;

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
     * @return Parameters
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
     * Set goodMarginPc
     *
     * @param integer $goodMarginPc
     *
     * @return Parameters
     */
    public function setGoodMarginPc($goodMarginPc)
    {
        $this->good_margin_pc = $goodMarginPc;

        return $this;
    }

    /**
     * Get goodMarginPc
     *
     * @return integer
     */
    public function getGoodMarginPc()
    {
        return $this->good_margin_pc;
    }

    /**
     * Set goodVatPc
     *
     * @param integer $goodVatPc
     *
     * @return Parameters
     */
    public function setGoodVatPc($goodVatPc)
    {
        $this->good_vat_pc = $goodVatPc;

        return $this;
    }

    /**
     * Get goodVatPc
     *
     * @return integer
     */
    public function getGoodVatPc()
    {
        return $this->good_vat_pc;
    }

    /**
     * Set serviceVatPc
     *
     * @param integer $serviceVatPc
     *
     * @return Parameters
     */
    public function setServiceVatPc($serviceVatPc)
    {
        $this->service_vat_pc = $serviceVatPc;

        return $this;
    }

    /**
     * Get serviceVatPc
     *
     * @return integer
     */
    public function getServiceVatPc()
    {
        return $this->service_vat_pc;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Parameters
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
     * @return Parameters
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
     * @return Parameters
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
     * @return Parameters
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
}
