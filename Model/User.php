<?php

class User extends AppModel {
    /*
     * @var Role
     * @var Aro
     */

    public $name = 'User';
    public $useTable = 'users';
    public $displayField = 'email';
    public $actsAs = array('Containable');
    public $belongsTo = [
        'Role' => [
            'className' => 'Role',
            'foreignKey' => 'categoria'
        ],
        'Alunonovo' => [
            'className' => 'Alunonovo',
            'foreignKey' => 'estudante_id'
        ],
        'Supervisor' => [
            'className' => 'Supervisor',
            'foreignKey' => 'supervisor_id',
        ],
        'Professor' => [
            'className' => 'Professor',
            'foreignKey' => 'docente_id',
        ]
    ];

    public function beforeValidate($options = array()) {

        $this->data['User']['password'] = SHA1($this->data['User']['password']);
        $this->data['User']['email'] = strtolower($this->data['User']['email']);
        // pr($this->data['User']['email']);
        return true;
    }

    public $validate = array(
        'categoria' => array(
            'rule' => array('inList', array('1', '2', '3', '4')),
            'message' => 'Selecione uma categoria de usuário',
            'required' => TRUE,
            'allowEmpty' => FALSE
        ),
        'numero' => array(
            'rule' => 'numeric',
            'required' => TRUE,
            'allowEmpty' => FALSE,
            'message' => 'Número: Digite somente números'
        ),
        'email' => array(
            'email1' => array(
                'rule' => 'email',
                'required' => TRUE,
                'allowEmpty' => FALSE,
                'message' => 'Email: Digite um email válido'
            ),
            'email2' => array(
                'rule' => 'isUnique',
                'on' => 'create',
                'message' => 'Email: Email já está cadastrado'
            )
        ),
        'password' => array(
            'rule' => 'notBlank',
            'message' => 'Senha: Digite uma senha',
            'required' => TRUE,
            'allowEmpty' => FALSE
        )
    );

}

?>
