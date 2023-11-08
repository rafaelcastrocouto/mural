<?php

class Professor extends AppModel {

    public $name = 'Professor';
    public $useTable = 'docentes';
    public $primaryKey = 'id';
    public $displayField = 'nome';
    public $actsAs = array('Containable');
    public $hasMany = array(
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => 'id_professor',
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'docente_id'
        ),
        /*
        'Extensao' => array(
            'className' => 'Extensao',
            'foreignKey' => 'docente_id',
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
         * 
         */
    );
        public $hasOne = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'docente_id'
        )
    );


    public function beforeValidate($options = array()) {

        // pr($this->data);
        $this->data['Professor']['nome'] = mb_convert_case($this->data['Professor']['nome'], MB_CASE_TITLE, 'utf-8');
        $this->data['Professor']['email'] = mb_convert_case($this->data['Professor']['email'], MB_CASE_LOWER, 'utf-8');
        // pr($this->data);
        // die();

        return true;
    }

}

?>
