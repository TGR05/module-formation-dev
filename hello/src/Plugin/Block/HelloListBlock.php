<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Hello List Block.
 *
 * @Block(
 *   id = "hello_list_block",
 *   admin_label = @Translation("Block list")
 * )
 */
class HelloListBlock extends BlockBase {
	
 /**
  * Implements Drupal\Core\Block\BlockBase::build().
  */
  
 
 public function build() {

 
  /* VERSION bis */
/*  $current_node = \drupal::service('current_route_match')->getParameter('node');
 if(is_a(current_node, 'Drupal\node\entity\Node')) $current_node_type = $current_node->getType();
 $query =\drupal::entityTypeManager()->getStorage('node')->getQuery();
 
 if(!enpty($current_node_type)){
	 $query->condition('type', $current_node_type);
 }else{
	 $query->condition('type', 'article');
 } */
 
 /* VERSION 1 */
 
 $query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
 $query->condition('type', 'article');
 $nids = $query->range(0,3)->sort('created', 'desc')->execute();
 
 
 $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);
 
 $items = array();
	
	foreach ($nodes as $node) {
	$items[] = $node->toLink();
	}
	
	$list = array(
	'#theme' => 'item_list',
	'#items' => $items,
	'#cache' => array(
		'context' => ['url'],
		'tag' => ['node:list'],
		)
	);
	
	
	return $list;
 }
}
 
 
 
