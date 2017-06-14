<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloRssController.
 */
 
namespace Drupal\Hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class HelloRssController extends ControllerBase {
	
	
 public function content() {
	
	 $response = new Response();
	 $response->headers->set('Content-type', 'application/json');
	 $response->setContent(json_encode(array(1, 2, 3)));
	 
	 return $response;
 }
}