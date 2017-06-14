<?php


/**
 * @file
 * Contains \Drupal\hello\Controller\HelloHistoryController.
 */
 
namespace Drupal\Hello\Controller;


use Drupal\Node\NodeInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HelloHistoryController extends ControllerBase {
	
	protected $database;
	protected $dateFormatter;
	
	public function __construct(Connection $database, DateFormatterInterface $dateFormatter) {
		$this->database = $database;
		$this->dateFormatter = $dateFormatter;
	}

	public static function create(ContainerInterface $container) {
		return new static(
		$container->get('database'),
		$container->get('date.formatter')
		);
	}
	
    public function history(NodeInterface $node) {
		
	$query = $this->database->select('hello_node_history', 'hnh')
	->fields('hnh', array('uid', 'update_time'))
	->condition('nid', $node->id());
	/* $results = $query->execute(); */
	
	$result = $query->extend('\Drupal\Core\Database\Query\PagerSelectExtender')->limit('5')->execute();
	
	$rows = array();
	$userStorage = $this->entityTypeManager()->getStorage('user');
	foreach ($result as $record) {
		$rows[] = array(
		$userStorage->load($record->uid)->toLink(),
		$this->dateFormatter->format($record->update_time, 'medium'),
		);
	}
	
	$count = $query->countQuery()->execute()->fetchField();
	$message = array(
		'#theme' => 'hello',
		'#node' => $node,
		'#count' => $count,
	);
	
	
	$table = array(
	'#theme' => 'table',
	'#header' => array($this->t('Author'), $this->t('Update time')),
	'#rows' => $rows,
	);
	
	$pager = array('#type' => 'pager');
	
	return array(
	'message' => $message,
	'table' => $table,
	'pager' => $pager,
	);
 }
}