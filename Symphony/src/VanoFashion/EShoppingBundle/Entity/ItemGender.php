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
     * Set gender
     *
     * @param string $gender
     *
     * @return ItemGender
     */
    public function setGender($gender)
    {
        $this->gender = strtolower($gender);

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

    public function __construct(){

        $this->addingDate= new \Datetime();
    }

    /**
     * Set addingDate
     *
     * @param \DateTime $addingDate
     *
     * @return ItemGender
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
     * @return ItemGender
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

        $array_gender=array();
        
        $array_gender['id']=$this->getId();
        $array_gender['gender']=$this->getGender();
        $array_gender['updatedAt']=$this->getUpdatedAt();
        $array_gender['addingDate']=$this->getAddingDate();

        

        return $array_gender;

    }
}
