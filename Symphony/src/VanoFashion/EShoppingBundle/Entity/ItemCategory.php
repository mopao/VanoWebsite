<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemCategory
 *
 * @ORM\Table(name="item_category")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\ItemCategoryRepository")
 */


class ItemCategory
{
    /**
     * represent item's category
     */

    /**
     * @ORM\OneToMany(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemProduct", mappedBy="category")
     */
    private $products;
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addingDate", type="datetime")
     */
    private $addingDate;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


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
     * Set name
     *
     * @param string $name
     *
     * @return itemCategory
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
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addingDate= new \Datetime();
    }

    /**
     * Add product
     *
     * @param \VanoFashion\EShoppingBundle\Entity\ItemProduct $product
     *
     * @return itemCategory
     */
    public function addProduct(\VanoFashion\EShoppingBundle\Entity\ItemProduct $product)
    {
        $this->products[] = $product;
        $product->setCategory($this);

        return $this;
    }

    /**
     * Remove product
     *
     * @param \VanoFashion\EShoppingBundle\Entity\ItemProduct $product
     */
    public function removeProduct(\VanoFashion\EShoppingBundle\Entity\ItemProduct $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set addingDate
     *
     * @param \DateTime $addingDate
     *
     * @return ItemCategory
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return ItemCategory
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
     * return corresponding array 
     */
    public function toArray(){

        $array_category=array();
        $array_products=array();

        $array_category['id']=$this->getId();
        $array_category['name']=$this->getName();
        $array_category['updatedAt']=$this->getUpdatedAt();
        $array_category['addingDate']=$this->getAddingDate();

        for ($i=0; $i < $this->products->count(); $i++) { 
            $array_products[]=$this->products->get($i)->toArray();
        }
        $array_category['products']=$array_products;

        return $array_category;

    }

}
