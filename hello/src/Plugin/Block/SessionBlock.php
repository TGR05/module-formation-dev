<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Provides a Session block.
 *
 * @Block(
 *   id = "Session_Block",
 *   admin_label = @Translation("Sessions Actives")
 * )
 */
class SessionBlock extends BlockBase {
	
 protected function blockAccess(AccountInterface $account) {
	$permission = 'access hello';
	 If($account->hasPermission($permission))return AccessResult::allowed();
	 return AccessResult::allowedIfHasPermission($account, $permission);
 }
 
 

 /**
  * Implements Drupal\Core\Block\BlockBase::build().
  */
 public function build() {
	 
	 $database = \drupal::database();
	 
	 $nusers = $database->select('sessions','s')
		->countQuery()
		->execute()
		->fetchfield();
	 
	 return array(
	 	'#markup' => $this->t('There is %nusers activ session', array(
		'%nusers' => $nusers )),
		'#cache' => array(
		'keys' => ['session_block'],
		'max-age' => '10',
		));
 }
}