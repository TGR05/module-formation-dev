<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class HelloForm extends FormBase {
	
		/* INJECTION DE DEPENDANCE */
	/* protected $state;
		public function __construct(StateInterface $State) {
			$this->state = $state;
		}
		public static function create(ContainerInterface $container) {
			return new static(
			$container->get('state')
			);
		} */
	
	public function getFormID() {
		return 'hello_form';
	}
	
	public function buildForm(array $form, FormStateInterface $form_state) {

	if (isset($form_state->getRebuildInfo()['result'])) {
			$form['result'] = array(
			'#markup' => '<h2>' . $this->t('Result: ') . $form_state->getRebuildInfo()['result'] . '</2>',
			);
		}
			
		$form['first_value'] = array(
		'#type' => 'textfield',
		'#title' => $this->t('First Value'),
		'#description' => $this->t('enter here your first value'),
		'#required' => TRUE,
		'#ajax' => array(
			'callback' => array($this, 'AjaxValidateNumeric'),
			'event' => 'change',
			),
		'#prefix' => '<span id="error-message-first_value"></span>',
		);
		
		$form['operation'] = [
		'#type' => 'radios',
		'#title' => $this->t('operation'),
		'#options' => (array(t('add'), t('soustract'), t('multiply'), t('divide'))),
		];
		
		$form['second_value'] = [
		'#type' => 'textfield',
		'#title' => $this->t('Second Value'),
		'#description' => $this->t('enter here your second value'),
		'#required' => TRUE,
		'#ajax' => array(
			'callback' => array($this, 'AjaxValidateNumeric'),
			'event' => 'change',
			),
		'#prefix' => '<span id="error-message-second_value"></span>',
		];
		
		$form['submit'] = [
		'#type' => 'submit',
		'#value' => $this->t('Calculate'),
		];
		
		return $form;
	}
	
	public function validateForm(array &$form, FormStateInterface $form_state) {
		if (($form_state->getValue('operation')) == 3 and (($form_state->getValue('second_value')) == 0)) {
        $form_state->setErrorByName('second_value', $this->t('Second Value can not be equal to 0.'));
		} /* else {
			if (is_numeric($form_state->getValue('first_value')) and is_numeric($form_state->getValue('second_value'))) {
				$form_state->drupal_set_message('ok');
			}
		} */
	}

	
	  public function submitForm(array &$form, FormStateInterface $form_state) {
		/* foreach ($form_state->getValues() as $key => $value) {drupal_set_message($key . ': ' . $value); */
	
	
	$first_value  = $form_state->getValue('first_value');
	$second_value = $form_state->getValue('second_value');
	$operation    = $form_state->getValue('operation');
	
	$resultat ='';
	switch ($operation) {
		case 0:
		$resultat = $first_value + $second_value;
		break;
		case 1:
		$resultat = $first_value - $second_value;
		break;
		case 2:
		$resultat = $first_value * $second_value;
		break;
		case 3:
		$resultat = $first_value / $second_value;
		break;
		}
		
	
		\Drupal::service('state')->set('submission_time', REQUEST_TIME);
		/* $this->state->set(Submission_date, REQUEST_TIME); */
		
		$form_state->addRebuildInfo('result', $resultat);
		$form_state->setRebuild();
	}
		
		public function AjaxValidateNumeric(array &$form, FormStateInterface $form_state) {
			$response = new \Drupal\Core\Ajax\AjaxResponse();
			
			$field = $form_state->getTriggeringElement()['#name'];
			$css = ['border' => '2px solid green'];
			$message = $this->t('OK!');
			if (!is_numeric($form_state->getValue($field))) {
				$css = ['border' => '2px solid red'];
				$message = $this->t('%field must be numeric!', array('%field' => $form[$field]['#title']));
			}
		
			$response->addCommand(new \Drupal\Core\Ajax\CssCommand("[name=$field]", $css));
			$response->addCommand(new HtmlCommand('#error-message-' . $field, $message));
			
			return $response;
		}
}