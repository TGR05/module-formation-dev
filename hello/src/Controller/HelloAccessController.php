<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */
 
namespace Drupal\Hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user;
use Drupal\Core\Session\AccountProxyInterface;


class HelloAccessController extends ControllerBase {
	
	public function content() {
		
	/* 	$date = $this->currentUser()->getCreatedTime();
		 
		
		return $date; */
		
		 $build = array(
		'#markup' => ('coucou'),
		);
		
		return $build;
	}
}