<?php
App::uses('AppModel', 'Model');
/**
 * Folhadeatividade Model
 *
 * @property Estagiario $Estagiario
 */
class Folhadeatividade extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'atividade';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Estagiario' => array(
			'className' => 'Estagiario',
			'foreignKey' => 'estagiario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
