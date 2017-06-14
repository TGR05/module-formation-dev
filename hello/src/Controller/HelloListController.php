<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloListController.
 */
 
namespace Drupal\Hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloListController extends ControllerBase {
	
	
 public function content($nodetype) {
	 
	$query = $this->entityTypeManager()->getStorage('node')->getQuery();
	
	// si on a un argument dans l'URL, on ne cible que les noeuds correspondants
	if($nodetype) {
		$query->condition('type', $nodetype);
	}
	
	// on construit une requete paginée
	$nids = $query->pager('10')->execute();
	
	// Charge les noeuds correspondants au résultat de la requete
	// $node_example = \drupal::service('entity.manager')->getStorage('node')->load(2);
	$nodes = $this->entityTypeManager()->getStorage('node')->loadMultiple($nids);

	//construit un tableau de lien vers les noeuds
	$items =array();
	
	foreach($nodes as $node) {
	$items[] = $node->toLink();
	}
	
	// render arrays à afficher
	$list = array(
	
	'#theme' => 'item_list',
	'#items' => $items,
	);
	
	$pager = array(
	'#type' => 'pager',
	);
	
	return array(
	'list' => $list,
	'page' => $pager
	);
 }
}