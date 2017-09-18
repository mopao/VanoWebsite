<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * itemCategory
 *
 * @ORM\Table(name="item_category")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\itemCategoryRepository")
 */


class itemCategory
{
    /**
     * represent item's category
     */

    /**
     * @ORM\OneToMany(targetEntity="VanoFashion\EShoppingBundle\Entity\itemProduct", mappedBy="category")
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
    }

    /**
     * Add product
     *
     * @param \VanoFashion\EShoppingBundle\Entity\itemProduct $product
     *
     * @return itemCategory
     */
    public function addProduct(\VanoFashion\EShoppingBundle\Entity\itemProduct $product)
    {
        $this->products[] = $product;
        $product->setCategory($this);

        return $this;
    }

    /**
     * Remove product
     *
     * @param \VanoFashion\EShoppingBundle\Entity\itemProduct $product
     */
    public function removeProduct(\VanoFashion\EShoppingBundle\Entity\itemProduct $product)
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
}
