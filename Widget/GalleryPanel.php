<?php

namespace BRS\GalleryBundle\Widget;

use BRS\CoreBundle\Core\Widget\PanelWidget;
use BRS\CoreBundle\Core\Widget\EditFormWidget;
use BRS\CoreBundle\Core\Utility;

use BRS\GalleryBundle\Entity\Gallery;
use BRS\GalleryBundle\Entity\GalleryFile;
use BRS\GalleryBundle\Widget\GalleryFileList;


/**
 * Gallery panel lets you add, edit, remove and reorder images in a gallery
 */
class GalleryPanel extends PanelWidget
{
	
	protected $template = 'BRSCoreBundle:Widget:panel.html.twig';
	
	protected $edit_widget;
	
	protected $file_list;
	
	protected $gallery;
	
	public function setup(){
			
		$edit_fields = array(
		
			'title' => array(
				'type' => 'text',
				'required' => true,
			),
			
			'route' => array(
				'type' => 'text',
				'required' => true,
			),
		);
		
		$this->edit_widget = new EditFormWidget();
		$this->edit_widget->setFields($edit_fields);
		
		$this->file_list = new GalleryFileList();

		$this->addWidget($this->edit_widget, 'edit_gallery');		
		$this->addWidget($this->file_list, 'gallery_images');
		
		$this->addListener($this->edit_widget, 'get.id', 'onParentGetById');
		$this->addListener($this->file_list, 'get.id', 'onSearchEvent');
		
		$this->setWidgets(array(
			'edit_widget' =>& $this->edit_widget,
			'gallery_images' =>& $this->file_list,
		));
	}
	
	
	public function getById($id){
		
		parent::getById($id);
		
		$this->sessionSet('gallery_id', $id);
		
		$this->file_list->sessionSet('gallery_id', $id);
		
		$this->file_list->setFilters(
			array(
				array(
					'filter' => 'g.gallery_id = :id',
					'params' => array('id' => $id),
				)
			)
		);
	}
	
	
	public function getVars($render = true){
		
		$add_vars = array(
			'gallery' => $this->gallery,
		);
		
		$vars = array_merge(parent::getVars(), $add_vars);
		
		return $vars;
	}
	
		
}