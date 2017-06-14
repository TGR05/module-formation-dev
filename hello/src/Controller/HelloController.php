<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */
 
namespace Drupal\Hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {
	
	
 public function content($paramuser) {
	 $message = $this->t('You are on the Hello page and your name is %username ! URL parameter is %paramuser.', array(
	 '%username' => $this->currentUser()->getAccountname(),
	 '%paramuser' => $paramuser,
	 ));
	 
	 $build = array(
		'#markup' => $message,
		'#cache' => array(
			'keys' => ['hello_page'],
			'contexts' => ['user', 'url.path'],
			'tags' => ['user:'.$this->currentUser()->id()],
		),
	);
		
	 
	 return $build;
 }
}



