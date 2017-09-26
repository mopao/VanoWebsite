<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemGender
 *
 * @ORM\Table(name="item_gender")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\ItemGenderRepository")
 */


class ItemGender
{

    /**
     * represent item's type
     */
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
     * @ORM\Column(name="gender", type="string", length=255, unique=true)
     */
    private $gender;


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
     * Set gender
     *
     * @param string $gender
     *
     * @return ItemGender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }
}
