<?php

App::uses('AppModel', 'Model');
/**
 * Complemento Model
 *
 * @property Estagiario $Estagiario
 */
class Complemento extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'periodo_especial';
        public $actsAs = array('Containable');
	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Estagiario' => array(
			'className' => 'Estagiario',
			'foreignKey' => 'complemento_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
