<?php

namespace BRS\GalleryBundle\Entity;

use BRS\CoreBundle\Core\SuperEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BRS\GalleryBundle\Entity\Gallery
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Gallery extends SuperEntity
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
     * @var datetime $created_time
     *
     * @ORM\Column(name="created_time", type="datetime", nullable=true)
     */
    public $created_time;

    /**
     * @var string $route
     *
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
}