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
     * @Route("/")
     * @Template("BRSPageBundle:Page:default.html.twig")
     */
    public function galleryIndexAction()
    {	
		$repo = $this->getRepository('BRSGalleryBundle:Gallery');
			
        $galleries = $repo->findBy(array(),array('display_order' => 'ASC'));
		
		$gallery = $galleries[0];
		
		$template = $this->getQuery('template');
		
		$helper = $this->galleryHelper($gallery, $galleries, $template);
		
		if($this->getQuery('render')){
			
			return $this->response($helper['rendered']);
		}
		
		if($this->isAjax()){
			
			//die('here' . $template);
			
			return $this->jsonResponse($helper);
				
		}else{
		
			return $helper;
		}
	}
	
	
	/**
     * @Route("/list")
     * @Template("BRSGalleryBundle:Default:gallery.list.html.twig")
     */
    public function galleryListAction()
    {
        $repo = $this->getRepository('BRSGalleryBundle:Gallery');
			
        $galleries = $repo->findBy(array(),array('display_order' => 'ASC'));
		
		return array('galleries' => $galleries);
    }
	
    /**
     * @Route("/{gallery_route}")
     * @Template("BRSPageBundle:Page:default.html.twig")
     */
    public function galleryAction($gallery_route)
    {
        $repo = $this->getRepository('BRSGalleryBundle:Gallery');
			
        $galleries = $repo->findBy(array(),array('display_order' => 'ASC'));
				
		$gallery = $repo->findOneByRoute($gallery_route);
		
		if($this->isAjax()){
			
			$template = $this->getQuery('template');
			
			//die('here' . $template);
			
			return $this->jsonResponse($this->galleryHelper($gallery, $galleries, $template));
				
		}else{
		
			return $this->galleryHelper($gallery, $galleries);
		}
    }
	
	/**
     * Helper for actions that render a gallery view
     */
	public function galleryHelper($gallery, $galleries, $template = null){
		
		$page = null;
		$nav = null;
		$route = null;
		
		$route = $this->getQuery('route');
		
		if(!$template && !$route){	
			
			$path = '';
			
			if($_SERVER['PATH_INFO']){
			
				$path = explode('/', $_SERVER['PATH_INFO']);
			
			}else{
				
				$path = explode('/', $_SERVER['SCRIPT_URL']);
			}
			
			$route = $path[1];
		}
		
		if($route){
				
			//die($route);
			
			$nav = $this->getNav($route);
					
			$page = $this->lookupPage($route);
			
			if( (!is_object($page)) || (!is_object($gallery)) ){
				
				throw $this->createNotFoundException('This is not the page you\'re looking for...');
			}
			
			$template = $page->template;
		}
		
		$gallery->setEntityManager($this->getEntityManager());
		
		$files = $gallery->getFiles();
		
		$page_vars = array(
			'gallery' => $gallery,
			'galleries' => $galleries,
			'files' => $files,
			'page' => $page,
			'nav' => $nav,
		);
		
		$rendered = $this->container->get('templating')->render($template, $page_vars);
		
		$vars = array(
			'route' => $route,
			'rendered' => $rendered,
			'page' => $page,
			'nav' => $nav,
		);
		
		return $vars;
	}
	
	
	
	
}
