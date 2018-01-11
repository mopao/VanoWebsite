<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ItemStock
 *
 * @ORM\Table(name="item_stock")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\ItemStockRepository")
 */


class ItemStock
{



    /**
     * represent item's stock
     */

    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\Item", inversedBy="stocks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $item;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="itemSize", type="float")
     *  @Assert\Range(min=0, minMessage=" the value must be equal or higher than {{limit}}.",invalidMessage="Enter a valid integer.")
     */
    private $itemSize;

     /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     *  @Assert\Range(min=1, minMessage=" the price must be equal or higher than {{limit}}.",invalidMessage="Enter a valid price.")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="typeSize", type="string", length=4)
     * @Assert\NotBlank()
     */
    private $typeSize;

    
    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\Range(min=0, minMessage=" the value must be equal or higher than {{limit}}.",invalidMessage="Enter a valid integer.")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="soldQuantity", type="integer")
     * @Assert\Range(min=0, minMessage=" the value must be equal or higher than {{limit}}.",invalidMessage="Enter a valid integer.")
     */
    private $soldQuantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addingDate", type="datetime")
     * @Assert\Datetime()
     */
    private $addingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfEnd", type="datetime", nullable=true)
     * @Assert\Datetime()
     */
    private $dateOfEnd;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Assert\Datetime()
     */
    private $updatedAt;

    
    public function __construct(){

        $this->addingDate= new \Datetime();
        $this->soldQuantity=0;
    }
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
        $this->typeSize = strtolower($typeSize);

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

    /**
     * Set item
     *
     * @param \VanoFashion\EShoppingBundle\Entity\Item $item
     *
     * @return ItemStock
     */
    public function setItem(\VanoFashion\EShoppingBundle\Entity\Item $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \VanoFashion\EShoppingBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return ItemStock
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set soldQuantity
     *
     * @param integer $soldQuantity
     *
     * @return ItemStock
     */
    public function setSoldQuantity($soldQuantity)
    {
        $this->soldQuantity = $soldQuantity;

        return $this;
    }

    /**
     * Get soldQuantity
     *
     * @return integer
     */
    public function getSoldQuantity()
    {
        return $this->soldQuantity;
    }

    /** 
     *increase soldQuantity with quantity
     *
     * @param integer $quantity
     *
     * 
     */
    public function increaseSoldQuantity($quantity){

        $this->setSoldQuantity($this->getSoldQuantity()+ $quantity);

    }

    /** 
     *decrease soldQuantity with quantity
     *
     * @param integer $quantity
     *
     * 
     */

    public function decreaseSoldQuantity($quantity){

        $this->setSoldQuantity($this->getSoldQuantity()- $quantity);

    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * return corresponding array 
     */
    public function toArray(){

        $array_stock=array();       

        $array_stock['id']=$this->getId();
        $array_stock['itemSize']=$this->getItemSize();
        $array_stock['updatedAt']=$this->getUpdatedAt();
        $array_stock['addingDate']=$this->getAddingDate();
        $array_stock['typeSize']=$this->getTypeSize();
        $array_stock['quantity']=$this->getQuantity();
        $array_stock['price']=$this->getPrice();
        $array_stock['soldQuantity']=$this->getSoldQuantity();
        $array_stock['dateOfEnd']=$this->getDateOfEnd();        

        return $array_stock;

    }

}
