<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\ItemRepository")
 */
class Item
{

    /**
     * represent item
     */
    /**
     * @ORM\OneToMany(targetEntity="VanoFashion\EShoppingBundle\Entity\Image", mappedBy="item",cascade={"remove"})
     */
    private $images; 
    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemGender")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;
    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemProduct")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    
    /**
     * @ORM\OneToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemStock", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)   
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
     * @ORM\Column(name="descrip", type="string", length=255, nullable=true)
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

    private $files;
    private $oldFileNames;
    
    
    public function getFiles()
    {
        return $this->files;
    }

    
    public function setFiles(array $files=null)
    {
        $this->files = $files;

        if($this->images!==null){

            foreach ($image as $this->images) {

                $oldFileNames[]=$image->getUrl();
            }

            $this->images->clear();

        }


        

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
      public function preUpload()
      {
        
        if (null === $this->files) {
          return;
        }


        foreach ($file as $this->files) {

            if ($file instanceof UploadedFile) {

                $image = new \VanoFashion\EShoppingBundle\Entity\Image();
                $image->setAlt($file->getClientOriginalName());
                $fileName=md5(uniqid()).'.'.$file->guessExtension();
                $image->setUrl($fileName);                
                $this->images->addImage($image);
                
                
            }
        }

        
      }


       /**
       * @ORM\PostPersist()
       * @ORM\PostUpdate()
       */
      public function upload()
      {
        
        if (null === $this->files) {
          return;
        }

        // remove old images item
        if (null !== $this->oldFileNames) {
          foreach ($oldFileName as $oldFileNames) {
              if (file_exists($oldFileName)) {
                unlink($oldFileName);
              }
          }

          $this->oldFileNames= array();
          
        }

        $nbImages=count($this->files);

        // move picture to the directory /web/bundles/vanofashioneshopping/images
        for ($i=0; $i < nbImages ; $i++) { 
            if($this->files[$i] instanceof UploadedFile){

                $this->files[$i]->move($this->getParameter('%kernel.project_dir%/web/bundles/vanofashioneshopping/images'),
                $this->images->get($i)->getUrl());

            }
        }
      }


      /**
       * @ORM\PreRemove()
       */
      public function preRemoveUpload()
      {

        foreach ($image as $this->images) {
            $this->oldFileNames[]=$image->getUrl();
        }
      }

      /**
       * @ORM\PostRemove()
       */
      public function removeUpload()
      {
        // remove all item images
        foreach ($fileName as $this->oldFileNames) {
            if (file_exists($fileName)) {
              // delete the image file
              unlink($fileName);
            }
        }

        $this->oldFileNames[]=  array();
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
     * Set product
     *
     * @param \VanoFashion\EShoppingBundle\Entity\itemProduct $product
     *
     * @return item
     */
    public function setProduct(\VanoFashion\EShoppingBundle\Entity\itemProduct $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \VanoFashion\EShoppingBundle\Entity\itemProduct
     */
    public function getProduct()
    {
        return $this->product;
    }

   

    /**
     * Set stock
     *
     * @param \VanoFashion\EShoppingBundle\Entity\itemStock $stock
     *
     * @return item
     */
    public function setStock(\VanoFashion\EShoppingBundle\Entity\itemStock $stock)
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->available=true;
        $this->oldFileNames= array();
    }

    /**
     * Add image
     *
     * @param \VanoFashion\EShoppingBundle\Entity\Image $image
     *
     * @return item
     */
    public function addImage(\VanoFashion\EShoppingBundle\Entity\Image $image)
    {
        
        $this->images[] = $image;
        $image->setItem($this);

        return $this;
    }

    /**
     * Remove image
     *
     * @param \VanoFashion\EShoppingBundle\Entity\Image $image
     */
    public function removeImage(\VanoFashion\EShoppingBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set gender
     *
     * @param \VanoFashion\EShoppingBundle\Entity\ItemGender $gender
     *
     * @return Item
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
}
