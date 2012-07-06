<?php

namespace BRS\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use BRS\CoreBundle\Core\Utility;
use BRS\PageBundle\Controller\PageController;

class GalleryController extends PageController
{
	
	/**
     * @Route("/portfolio")
     * @Template("BRSPageBundle:Page:default.html.twig")
     */
    public function galleryIndexAction()
    {
		$repo = $this->getRepository('BRSGalleryBundle:Gallery');
			
        $galleries = $repo->findAll();
		
		$gallery = $galleries[0];
		
		return $this->renderGallery($gallery, $galleries);	
	}
	
    /**
     * @Route("/portfolio/{gallery_route}")
     * @Template("BRSPageBundle:Page:default.html.twig")
     */
    public function galleryAction($gallery_route)
    {
        $repo = $this->getRepository('BRSGalleryBundle:Gallery');
			
        $galleries = $repo->findAll();
				
		$gallery = $repo->findOneByRoute($gallery_route);
		
		return $this->renderGallery($gallery, $galleries);
    }
	
	public function renderGallery($gallery, $galleries){
		
		$route = 'portfolio';
		
		$nav = $this->getNav($route);
				
		$page = $this->lookupPage($route);
		
		if( (!is_object($page)) || (!is_object($gallery)) ){
			
			throw $this->createNotFoundException('This is not the page you\'re looking for...');
		}
		
		$page_vars = array(
			'gallery' => $gallery,
			'galleries' => $galleries
		);
		
		$rendered = $this->container->get('templating')->render($page->template, $page_vars);
		
		
		$vars = array(
			'route' => $route,
			'rendered' => $rendered,
			'page' => $page,
			'nav' => $nav,
		);
			
		return $vars;
	}
	
}
