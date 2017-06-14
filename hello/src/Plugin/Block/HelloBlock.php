<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a hello block.
 *
 * @Block(
 *   id = "Hello_Block",
 *   admin_label = @Translation("Hello!")
 * )
 */
class HelloBlock extends BlockBase {

 /**
  * Implements Drupal\Core\Block\BlockBase::build().
  */
 public function build() {
	 
	 $dateFormatter = \Drupal::service('date.formatter');
	 $date = $dateFormatter->format(time(), 'long');
	 
	 

	 $build = array(
		'#markup' => $this->t('It is %time.', array(
		'%time' => $date,
		)),
		'#cache' => array(
		'keys' => ['hello_block'],
		'max-age' => '10',
		),
	 );
	 return $build;
 }
 
}