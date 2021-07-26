<?php
App::uses('AppModel', 'Model');
/**
 * Situacaopr5 Model
 *
 * @property Extensao $Extensao
 */
class Situacaopr5 extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'situacaopr5';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'situacao';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Extensao' => array(
			'className' => 'Extensao',
			'foreignKey' => 'situacaopr5_id',
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
