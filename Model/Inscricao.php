<?php

class Inscricao extends AppModel {
    /* @var Mural */
    /* @var Aluno */
    /* @var Alunonovo */

    public $name = 'Inscricao';
    public $useTable = 'mural_inscricao';
    public $primaryKey = 'id';
    public $actsAs = array('Containable');
    public $belongsTo = array(
        'Mural' => array(
            'className' => 'Mural',
            'foreignKey' => 'id_instituicao',
        ),
        'Aluno' => array(
            'className' => 'Aluno',
            'foreignKey' => 'aluno_id'
        ),
        'Alunonovo' => array(
            'className' => 'Alunonovo',
            'foreignKey' => 'alunonovo_id',
            'counterCache' => true
        ),
        'Estagiario' => array(
            'className' => 'Estagiario',
            'foreignKey' => FALSE,
            'conditions' => 'Inscricao.id_aluno = Estagiario.registro'
        )
    );

}

?>
