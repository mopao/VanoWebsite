<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\item" , inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
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
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var bool
     *
     * @ORM\Column(name="ismain", type="boolean")
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
    public function getIsmain()
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
    public function setItem(\VanoFashion\EShoppingBundle\Entity\item $item)
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
}
