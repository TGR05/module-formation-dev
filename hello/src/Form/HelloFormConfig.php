<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class HelloFormConfig extends ConfigFormBase {
	
	  
	public function getFormID() {
		return 'hello_form';
	}
	
	protected function getEditableConfigNames() {
		return array('hello.config');
		
	}
	
	public function buildForm(array $form, FormStateInterface $form_state) {
		
		$color = $this->config('hello.config')->get('color');
		
		$form['color'] = array(
		'#type' => 'select',
		'#title' => $this->t('block color'),
		'#description' => $this->t('Will set the color of your blocks'),
		'#required' => TRUE,
		'#default_value' => $color,
		'#options' => [
			'blue-class' => $this->t('blue'),
			'red-class' => $this->t('red'),
			'green-class' => $this->t('green'),
	]);
	
	/* 	$form['submit'] = [
		'#type' => 'submit',
		'#value' => $this->t('Change'),
		]; */
		
		return parent::buildForm($form, $form_state);
		/* return $form; */
		
	}
	
	public function validateForm(array &$form, FormStateInterface $form_state) {

	}
	
	public function submitForm(array &$form, FormStateInterface $form_state) {
		
		
		$this->config('hello.config')
			->set('color', $form_state->getValue('color'))
			->save();
			
		\Drupal::service('entity_type.manager')->GetViewBuilder('block')->resetCache();
			
			
 		/* $color = $form_state->getValue('color'); */
		
		
		/* \Drupal::config('hello.config')->setValue('color', $color); */

	
	}
}