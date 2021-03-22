<?php

App::uses('AppModel', 'Model');

/**
 * Tae Model
 *
 * @property Extensao $Extensao
 */
class Tae extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'nome';
    // The Associations below have been created with all possible keys, those that are not needed can be removed
    public $actsAs = array('Containable');

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Extensao' => array(
            'className' => 'Extensao',
            'foreignKey' => 'tae_id',
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
