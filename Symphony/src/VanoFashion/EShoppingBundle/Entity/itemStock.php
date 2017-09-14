<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * itemStock
 *
 * @ORM\Table(name="item_stock")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\itemStockRepository")
 */
class itemStock
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="itemSize", type="float")
     */
    private $itemSize;

    /**
     * @var string
     *
     * @ORM\Column(name="typeSize", type="string", length=4)
     */
    private $typeSize;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addingDate", type="datetime")
     */
    private $addingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfEnd", type="datetime", nullable=true)
     */
    private $dateOfEnd;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set itemSize
     *
     * @param integer $itemSize
     *
     * @return itemStock
     */
    public function setItemSize($itemSize)
    {
        $this->itemSize = $itemSize;

        return $this;
    }

    /**
     * Get itemSize
     *
     * @return int
     */
    public function getItemSize()
    {
        return $this->itemSize;
    }

    /**
     * Set typeSize
     *
     * @param string $typeSize
     *
     * @return itemStock
     */
    public function setTypeSize($typeSize)
    {
        $this->typeSize = $typeSize;

        return $this;
    }

    /**
     * Get typeSize
     *
     * @return string
     */
    public function getTypeSize()
    {
        return $this->typeSize;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return itemStock
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set addingDate
     *
     * @param \DateTime $addingDate
     *
     * @return itemStock
     */
    public function setAddingDate($addingDate)
    {
        $this->addingDate = $addingDate;

        return $this;
    }

    /**
     * Get addingDate
     *
     * @return \DateTime
     */
    public function getAddingDate()
    {
        return $this->addingDate;
    }

    /**
     * Set dateOfEnd
     *
     * @param \DateTime $dateOfEnd
     *
     * @return itemStock
     */
    public function setDateOfEnd($dateOfEnd)
    {
        $this->dateOfEnd = $dateOfEnd;

        return $this;
    }

    /**
     * Get dateOfEnd
     *
     * @return \DateTime
     */
    public function getDateOfEnd()
    {
        return $this->dateOfEnd;
    }
}

