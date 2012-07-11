<?php

namespace BRS\GalleryBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use BRS\CoreBundle\Core\Widget\ListWidget;
use BRS\CoreBundle\Core\Widget\EditFormWidget;
use BRS\CoreBundle\Core\Widget\PanelWidget;
use BRS\AdminBundle\Controller\AdminController;

use BRS\GalleryBundle\Entity\Gallery;
use BRS\GalleryBundle\Widget\GalleryPanel;

/**
 * Gallery admin controller.
 *
 * @Route("/admin/gallery")
 */
class GalleryAdminController extends AdminController
{
		
	protected function setup()
	{
		parent::setup();
				
		$this->setRouteName('brs_gallery_galleryadmin');
		$this->setEntityName('BRSGalleryBundle:Gallery');
		$this->setEntity(new Gallery());
		
		$list_fields = array(
			'edit' => array(
				'type' => 'link',
				'route' => array(
					'name' => 'brs_gallery_galleryadmin_edit',
					'params' => array('id'),
				),
				'nav' => true,
				'label' => 'edit',
				'width' => 55,
				'nonentity' => true,
				'class' => 'btn btn-mini',
			),
			'title' => array(
				'type' => 'text',
			),
		);
		
		$list_widget = new ListWidget();
		$list_widget->setListFields($list_fields);
		$list_widget->setReorderField('display_order');
		$this->addWidget($list_widget, 'list_galleries');
	
		$new_fields = array(
		
			'title' => array(
				'type' => 'text',
				'required' => true,
			),
		);
		
		$new_widget = new EditFormWidget();
		$new_widget->setFields($new_fields);
		$new_widget->setSuccessRoute('brs_gallery_galleryadmin_edit');
		$this->addWidget($new_widget, 'new_gallery');
		
		$gallery_panel = new GalleryPanel();
		$this->addWidget($gallery_panel, 'gallery_panel');
		
		$this->addView('index', $list_widget);
		$this->addView('new', $new_widget);
		$this->addView('edit', $gallery_panel);
	}
	
}