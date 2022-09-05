<?php

App::uses('AppModel', 'Model');

/**
 * Extensao Model
 *
 * @property Docente $Docente
 */
class Extensao extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'extensoes';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'titulo';
    public $actsAs = array('Containable');

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Professor' => array(
            'className' => 'Professor',
            'foreignKey' => 'docente_id',
            'conditions' => '',
            'fields' => '',
            'order' => 'Professor.nome'
        ),
        'Tae' => array(
            'className' => 'Tae',
            'foreignKey' => 'tae_id',
            'conditions' => '',
            'fields' => '',
            'order' => 'Tae.nome'
        ),
        'Situacaopr5' => array(
            'className' => 'Situacaopr5',
            'foreignKey' => 'situacaopr5_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
