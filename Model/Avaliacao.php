<?php

App::uses('AppModel', 'Model');

/**
 * Avaliacao Model
 *
 * @property Estagiario $Estagiario
 */
class Avaliacao extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'estagiario_id';
    // The Associations below have been created with all possible keys, those that are not needed can be removed
    public $actsAs = array('Containable');

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
    
    public $validate = array(
        'estagiario_id' => array(
            'rule' => 'isUnique',
            'required' => 'create',
            'message' => 'Já foi avaliado'
        )
    );

}
