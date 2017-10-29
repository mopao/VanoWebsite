<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ItemProduct
 *
 * @ORM\Table(name="item_product")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\ItemProductRepository")
 */

class ItemProduct
{

    /**
     * represent item's product
     */

    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemCategory", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemGender")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;

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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;


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
     * @return itemProduct
     */
    public function setName($name)
    {
        $this->name = strtolower($name);

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
     * Set category
     *
     * @param \VanoFashion\EShoppingBundle\Entity\ItemCategory $category
     *
     * @return itemProduct
     */
    public function setCategory(\VanoFashion\EShoppingBundle\Entity\ItemCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \VanoFashion\EShoppingBundle\Entity\ItemCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __construct(){

        $this->addingDate= new \Datetime();
    }

    /**
     * Set addingDate
     *
     * @param \DateTime $addingDate
     *
     * @return ItemProduct
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
     * @return ItemProduct
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
     * Set slug
     *
     * @param string $slug
     *
     * @return ItemProduct
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set gender
     *
     * @param \VanoFashion\EShoppingBundle\Entity\ItemGender $gender
     *
     * @return ItemProduct
     */
    public function setGender(\VanoFashion\EShoppingBundle\Entity\ItemGender $gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \VanoFashion\EShoppingBundle\Entity\ItemGender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * return corresponding array 
     */
    public function toArray(){

        $array_product=array();
        $array_product['id']=$this->getId();
        $array_product['category']=$this->getCategory()->getName();
        $array_product['gender']=$this->getGender()->getGender();
        $array_product['addingDate']=$this->getAddingDate();
        $array_product['updatedAt']=$this->getUpdatedAt();
        $array_product['name']=$this->getName();

        return $array_product;

    }
}
