<?php 

namespace Drupal\hello\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    $route = $collection->get('system.modules_list'); 
	$route1 = $collection->get('system.modules_uninstall'); 
    $route->setRequirement('_access', 'FALSE'); 
	$route1->setRequirement('_access', 'FALSE');
  }

  
}