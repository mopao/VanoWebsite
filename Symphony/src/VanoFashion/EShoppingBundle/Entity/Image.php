<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\ImageRepository")
 */


class Image
{

    /**
     * represent item's image
     */ 
    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\Item" , inversedBy="images")
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $alt;

    /**
     * @var bool
     *
     * @ORM\Column(name="ismain", type="boolean")
     * @Assert\Type("bool")
     */
    private $ismain;


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
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set ismain
     *
     * @param boolean $ismain
     *
     * @return Image
     */
    public function setIsmain($ismain)
    {
        $this->ismain = $ismain;

        return $this;
    }

    /**
     * Get ismain
     *
     * @return bool
     */
    public function ismain()
    {
        return $this->ismain;
    }

    /**
     * Set item
     *
     * @param \VanoFashion\EShoppingBundle\Entity\item $item
     *
     * @return Image
     */
    public function setItem(\VanoFashion\EShoppingBundle\Entity\Item $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \VanoFashion\EShoppingBundle\Entity\item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ismain=false;
    }

    /**
     * return corresponding array 
     */
    public function toArray(){

        $array_image=array();        

        $array_image['id']=$this->getId();
        $array_image['url']=$this->getUrl();
        $array_image['alt']=$this->getAlt();
        $array_image['ismain']=$this->ismain();       

        return $array_image;

    }
}
