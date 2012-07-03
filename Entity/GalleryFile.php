<?php

namespace BRS\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BRS\GalleryBundle\Entity\GalleryFile
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GalleryFile
{
    

    /**
     * @var integer $id
     *
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var integer $gallery_id
     *
     * @ORM\Column(name="gallery_id", type="integer")
     */
    public $gallery_id;

    /**
     * @var integer $file_id
     *
     * @ORM\Column(name="file_id", type="integer")
     */
    public $file_id;

    /**
     * @var integer $display_order
     *
     * @ORM\Column(name="display_order", type="integer", nullable=true)
     */
    public $display_order;
	
	/**
     * @ORM\ManyToOne(targetEntity="Gallery")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     */
    public $gallery;
	
	/**
     * @ORM\ManyToOne(targetEntity="BRS\FileBundle\Entity\File")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     */
    public $file;
	
	/*
    public function __construct($gallery_id, $file_id)
    {
        $this->gallery_id = $gallery_id;
        $this->file_id = $file_id;
    }
	 * */

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
     * Set gallery_id
     *
     * @param integer $galleryId
     */
    public function setGalleryId($galleryId)
    {
        $this->gallery_id = $galleryId;
    }

    /**
     * Get gallery_id
     *
     * @return integer 
     */
    public function getGalleryId()
    {
        return $this->gallery_id;
    }

    /**
     * Set gallery
     *
     * @param \BRS\GalleryBundle\Entity\Gallery  $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * Get gallery
     *
     * @return \BRS\GalleryBundle\Entity\Gallery  
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set file_id
     *
     * @param integer $fileId
     */
    public function setFileId($fileId)
    {
        $this->file_id = $fileId;
    }

    /**
     * Get file_id
     *
     * @return integer 
     */
    public function getFileId()
    {
        return $this->file_id;
    }
	
    /**
     * Set file
     *
     * @param \BRS\FileBundle\Entity\File $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return \BRS\FileBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set display_order
     *
     * @param integer $displayOrder
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->display_order = $displayOrder;
    }

    /**
     * Get display_order
     *
     * @return integer 
     */
    public function getDisplayOrder()
    {
        return $this->display_order;
    }
}