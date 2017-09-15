<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\itemRepository")
 */
class item
{

    /**
     * @ORM\OneToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\itemStock", cascade={"persist"})
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codeItem", type="string", length=255, unique=true)
     */
    private $codeItem;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * @var array
     *
     * @ORM\Column(name="descrip", type="array", nullable=true)
     */
    private $descrip;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255)
     */
    private $brand;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @var string
     *
     * @ORM\Column(name="itemLabel", type="string", length=255, nullable=true)
     */
    private $itemLabel;


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
     * Set codeItem
     *
     * @param string $codeItem
     *
     * @return item
     */
    public function setCodeItem($codeItem)
    {
        $this->codeItem = $codeItem;

        return $this;
    }

    /**
     * Get codeItem
     *
     * @return string
     */
    public function getCodeItem()
    {
        return $this->codeItem;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return item
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return item
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set descrip
     *
     * @param array $descrip
     *
     * @return item
     */
    public function setDescrip($descrip)
    {
        $this->descrip = $descrip;

        return $this;
    }

    /**
     * Get descrip
     *
     * @return array
     */
    public function getDescrip()
    {
        return $this->descrip;
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
     * Set brand
     *
     * @param string $brand
     *
     * @return item
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set available
     *
     * @param boolean $available
     *
     * @return item
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set itemLabel
     *
     * @param string $itemLabel
     *
     * @return item
     */
    public function setItemLabel($itemLabel)
    {
        $this->itemLabel = $itemLabel;

        return $this;
    }

    /**
     * Get itemLabel
     *
     * @return string
     */
    public function getItemLabel()
    {
        return $this->itemLabel;
    }

    /**
     * Set stock
     *
     * @param \VanoFashion\EShoppingBundle\Entity\itemStock $stock
     *
     * @return item
     */
    public function setStock(\VanoFashion\EShoppingBundle\Entity\itemStock $stock = null)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \VanoFashion\EShoppingBundle\Entity\itemStock
     */
    public function getStock()
    {
        return $this->stock;
    }
}
