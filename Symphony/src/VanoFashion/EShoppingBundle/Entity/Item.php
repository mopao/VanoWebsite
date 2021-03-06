<?php

namespace VanoFashion\EShoppingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="VanoFashion\EShoppingBundle\Repository\ItemRepository")
 *@ORM\HasLifecycleCallbacks()
 */
class Item
{

    /**
     * represent item
     */
    /**
     * @ORM\OneToMany(targetEntity="VanoFashion\EShoppingBundle\Entity\Image", mappedBy="item",cascade={"persist","remove"})
     *
     *
     */
    private $images; 
    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemGender")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $gender;
    /**
     * @ORM\ManyToOne(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemProduct")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $product;
    
     /**
     * @ORM\OneToMany(targetEntity="VanoFashion\EShoppingBundle\Entity\ItemStock", mappedBy="item",cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */    
     private $stocks;


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
     * @ORM\Column(name="codeItem", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $codeItem;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $color;

    /**
     * @var array
     *
     * @ORM\Column(name="descrip", type="string", length=255, nullable=true)
     */
    private $descrip;

   

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $brand;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     * @Assert\Type("bool")
     */
    private $available;

    /**
     * @var string
     *
     * @ORM\Column(name="itemLabel", type="string", length=255, nullable=true)
     */
    private $itemLabel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addingDate", type="datetime")
     * @Assert\DateTime()
     */
    private $addingDate;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $updatedAt;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;
   
    private $otherFiles;
    
    private $mainFile;
    private $oldFileNames;
    private $newFileNames;
    
    
    public function getOtherFiles()
    {
        return $this->otherFiles;
    }

    
    public function setOtherFiles(array $files=null)
    {
        $this->otherFiles = $files;

        if($this->images!==null){

            foreach ( $this->images as $image ) {

                if (!$image->ismain()) {
                    $oldFileNames[]=$image->getUrl();
                    $this->removeImage($image);
                
                }
            }

            

        }       
        
    }

    public function getMainFile()
    {
        return $this->mainFile;
    }

    
    public function setMainFile( $file=null)
    {
        $this->mainFile = $file;

        if($this->images!==null){

            foreach ( $this->images as $image ) {

                if ($image->ismain()) {
                    $oldFileNames[]=$image->getUrl();
                    $this->removeImage($image);
                    break;
                }
            }

            

        }        

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
      public function preUpload()
      {
        
        if (null === $this->mainFile && null === $this->otherFiles) {
          return;
        }
      
        if (null !== $this->mainFile) {
            

            if ($this->mainFile instanceof UploadedFile) {

                $image = new \VanoFashion\EShoppingBundle\Entity\Image();
                $image->setAlt($this->mainFile->getClientOriginalName());
                $fileName=md5(uniqid()).'.'.$this->mainFile->guessExtension();
                $image->setUrl($fileName);
                $image->setIsmain(true) ;          
                $this->addImage($image);
                $this->newFileNames[0]=$fileName;               
                
            }
            
        }

        if (null !== $this->otherFiles) {
            $i=1;
            foreach ( $this->otherFiles as $file) {

                if ($file instanceof UploadedFile) {

                    $image = new \VanoFashion\EShoppingBundle\Entity\Image();
                    $image->setAlt($file->getClientOriginalName());
                    $fileName=md5(uniqid()).'.'.$file->guessExtension();
                    $image->setUrl($fileName);                           
                    $this->addImage($image);
                    $this->newFileNames[$i]=$fileName;
                    $i++;

                    
                    
                }
            }
        }

        if(null !== $this->stocks){

            foreach ($this->stocks as $stock) {
                $stock->setItem($this);
            }

        }

        
      }


       /**
       * @ORM\PostPersist()
       * @ORM\PostUpdate()
       */
      public function upload()
      {
        
        if (null === $this->otherFiles && null === $this->mainFile) {
          return;
        }
         
        // remove old images item
        if (null !== $this->oldFileNames) {
          foreach ( $this->oldFileNames as $oldFileName) {
              if (file_exists(__DIR__.'/../../../../web/bundles/vanofashioneshopping/images/'.$oldFileName)) {
                unlink(__DIR__.'/../../../../web/bundles/vanofashioneshopping/images/'.$oldFileName);
              }
          }

          $this->oldFileNames= array();
          
        }

        if (null !== $this->otherFiles ) {

            $nbImages=count($this->otherFiles);
            // move picture to the directory /web/bundles/vanofashioneshopping/images
            for ($i=0; $i < $nbImages ; $i++) { 
                if($this->otherFiles[$i] instanceof UploadedFile){

                    $this->otherFiles[$i]->move(__DIR__.'/../../../../web/bundles/vanofashioneshopping/images',
                    $this->newFileNames[$i+1]);

                }
            }
          
        }

        if ( null !== $this->mainFile) {

            if($this->mainFile instanceof UploadedFile){

                $this->mainFile->move(__DIR__.'/../../../../web/bundles/vanofashioneshopping/images',
                $this->newFileNames[0]);

            }
        }

        $this->newFileNames= array();

        
      }


      /**
       * @ORM\PreRemove()
       */
      public function preRemoveUpload()
      {

        foreach ( $this->images as $image) {
            $this->oldFileNames[]=$image->getUrl();
        }
      }

      /**
       * @ORM\PostRemove()
       */
      public function removeUpload()
      {
        // remove all item images
        foreach ( $this->oldFileNames as $fileName) {
            if (file_exists(__DIR__.'/../../../../web/bundles/vanofashioneshopping/images/'.$fileName)) {
              // delete the image file
              unlink(__DIR__.'/../../../../web/bundles/vanofashioneshopping/images/'.$fileName);
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
     * Set name
     *
     * @param string $title
     *
     * @return item
     */
    public function setName($title)
    {
        $this->name = strtolower($title);

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
     * Set color
     *
     * @param string $color
     *
     * @return item
     */
    public function setColor($color)
    {
        $this->color = strtolower($color);

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
        $this->descrip = strtolower($descrip);

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
     * Set brand
     *
     * @param string $brand
     *
     * @return item
     */
    public function setBrand($brand)
    {
        $this->brand = strtolower($brand);

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
        $this->itemLabel = strtolower($itemLabel);

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
     * @return \VanoFashion\EShoppingBundle\Entity\Image $image
     * @Assert\Valid()
     */
    public function getMainImage()
    {
        
        foreach ($this->images as $image) {
            # code...
            if($image->ismain()){
                return $image;
            }
        }

        return null;
    }


    /**
     * Get item's main image
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

    /**
     * Add stock
     *
     * @param \VanoFashion\EShoppingBundle\Entity\ItemStock $stock
     *
     * @return Item
     */
    public function addStock(\VanoFashion\EShoppingBundle\Entity\ItemStock $stock)
    {
        $this->stocks[] = $stock;
        $stock->setItem($this);

        return $this;
    }

    /**
     * Remove stock
     *
     * @param \VanoFashion\EShoppingBundle\Entity\ItemStock $stock
     */
    public function removeStock(\VanoFashion\EShoppingBundle\Entity\ItemStock $stock)
    {
        $this->stocks->removeElement($stock);
    }

    /**
     * Get stocks
     *
     * @return \Doctrine\Common\Collections\Collection
     * @Assert\Valid()
     */
    public function getStocks()
    {
        return $this->stocks;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stocks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->available=true;
        $this->oldFileNames= array();
        $this->newFileNames= array();
        $this->addingDate= new \Datetime();
    }


    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Item
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
     * Set addingDate
     *
     * @param \DateTime $addingDate
     *
     * @return Item
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
     * @return Item
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

        $array_item=array();
        $array_images=array();
        $array_stocks=array();

        $array_item['id']=$this->getId();
        $array_item['codeItem']=$this->getCodeItem();
        $array_item['name']=$this->getName();
        $array_item['color']=$this->getColor();
        $array_item['descrip']=$this->getDescrip();
        $array_item['brand']=$this->getBrand();
        $array_item['available']=$this->getAvailable();
        $array_item['gender']=$this->getGender()->toArray();
        $array_item['addingDate']=$this->getAddingDate();
        $array_item['updatedAt']=$this->getUpdatedAt();
        $array_item['itemLabel']=$this->getItemLabel();
        $array_item['product']=$this->getProduct()->toArray();

        for ($i=0; $i < $this->stocks->count(); $i++) { 
            $array_stocks[]=$this->stocks->get($i)->toArray();
        }

        for ($i=0; $i < $this->images->count(); $i++) { 
            $array_images[]=$this->images->get($i)->toArray();
        }

        $array_item['stocks']=$array_stocks;
        $array_item['images']=$array_images;

        return $array_item;

    }
}
