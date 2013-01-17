<?php

namespace BRS\GalleryBundle\Entity;

use BRS\CoreBundle\Core\SuperEntity;
use BRS\FileBundle\Entity\File;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BRS\GalleryBundle\Entity\Gallery
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Gallery extends SuperEntity
{
	/*
	 * name of root folder that holds all entity sub-folders
	 */
    private $root_folder_name = 'Galleries';
	
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    public $title;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    public $description;

    /**
     * @var string $style
     *
     * @ORM\Column(name="style", type="string", length=255, nullable=true)
     */
    public $style;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * @var string $route
     *
	 * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    public $route;
	
	/**
     * @var integer $cover_file_id
     *
     * @ORM\Column(name="cover_file_id", type="integer", nullable=true)
     */
    public $cover_file_id;
	
	/**
     * @var integer $display_order
     *
     * @ORM\Column(name="display_order", type="integer", nullable=true)
     */
    public $display_order;
	
	
	/**
     * @var integer $dir_id
     *
     * @ORM\Column(name="dir_id", type="integer", nullable=TRUE)
     */
    public $dir_id;
	
	/*
	 * @ORM\OneToOne(targetEntity="BRS\FileBundle\Entity\File", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="dir_id", referencedColumnName="id")
	 */
	public $directory;
	
	
	/**
     * Get name of folder to create for this entity  
     *
     * @return string
     */
	public function getFolderName(){
		
		return $this->getTitle();
	}
	
	/**
	 * @ORM\PreRemove
	 */
	public function removeDirectory()
	{
		$dir_id = $this->getDirId();
		
		if($dir_id){
		
			$dir = $this->em->getReference('\BRS\FileBundle\Entity\File', $dir_id);
			
			$this->em->remove($dir);
		}
	}
	
	/**
	 * @ORM\PostUpdate
	 */
	public function updateDirectory()
	{
					
		$dir_id = $this->getDirId();
		
		if($dir_id){
				
			$dir = $this->em->getReference('\BRS\FileBundle\Entity\File', $dir_id);
			
			$folder_name = $this->getFolderName();
		
			$dir->setName($folder_name);
			
			$this->em->persist($dir);
			
			$this->em->flush();
		}
	}
	
	/**
	 * @ORM\PrePersist
	 */
	public function createDirectory()
	{	
		$dir = new File();
		
		$parent = $this->em->getRepository('BRSFileBundle:File')->getRootByName($this->root_folder_name);
		
		if($parent){
		
			$dir->setParent($parent);
		
			$dir->setIsDir(true);
			
			$folder_name = $this->getFolderName();
			
			$dir->setName($folder_name);
				
			$this->directory = $dir;
			
			$this->em->persist($dir);
			
			$this->em->flush();
			
			$this->setDirId($dir->id);
		}
	}
	
	/**
     * Get driectory
     *
     * @return BRS\FileBundle\Entity\File $dir
     */
    public function getDirectory()
    {
    	$dir_id = $this->getDirId();
		
		if($dir_id){
				
			$dir = $this->em->getRepository('BRSFileBundle:File')->findOneById($dir_id);
			
			return $dir;
		}
    }
	
	/**
     * Get files
     *
     * @return Doctrine\Common\Collections\Collection 
     */
	public function getFiles(){
		
		$file_repo = $this->em->getRepository('BRSFileBundle:File');
		
		$dir = $this->getDirectory();
		
		$files = $file_repo->children($dir, true);
		
		return $files;
	}
	
    /**
     * Set dir_id
     *
     * @param integer $dirId
     */
    public function setDirId($dirId)
    {
        $this->dir_id = $dirId;
    }

    /**
     * Get dir_id
     *
     * @return integer 
     */
    public function getDirId()
    {
        return $this->dir_id;
    }
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
    }
	
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set style
     *
     * @param string $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * Get style
     *
     * @return string 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set created_time
     *
     * @param datetime $createdTime
     */
    public function setCreatedTime($createdTime)
    {
        $this->created_time = $createdTime;
    }

    /**
     * Get created_time
     *
     * @return datetime 
     */
    public function getCreatedTime()
    {
        return $this->created_time;
    }

    /**
     * Set route
     *
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }
	
	/**
     * Get cover_file_id
     *
     * @return integer 
     */
    public function getCoverFileId()
    {
        return $this->cover_file_id;
    }
	
	/**
     * Set cover_file_id
     *
     * @param integer $cover_file_id
     */
    public function setCoverFileId($cover_file_id)
    {
        $this->cover_file_id = $cover_file_id;
    }
	
	/**
     * Get order
     *
     * @return int 
     */
    public function getDisplayOrder()
    {
        return $this->display_order;
    }

    /**
     * Set order
     *
     * @param int $display_order
     */
    public function setDisplayOrder($display_order)
    {
        $this->display_order = $display_order;
    }
}