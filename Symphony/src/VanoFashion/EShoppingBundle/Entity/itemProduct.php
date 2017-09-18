<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * itemProduct
 *
 * @ORM\Table(name="item_product")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\itemProductRepository")
 */

class itemProduct
{

    /**
     * represent item's product
     */

    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\itemCategory", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

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
     * @return itemProduct
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
     * Set category
     *
     * @param \VanoFashion\EShoppingBundle\Entity\itemCategory $category
     *
     * @return itemProduct
     */
    public function setCategory(\VanoFashion\EShoppingBundle\Entity\itemCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \VanoFashion\EShoppingBundle\Entity\itemCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
}
