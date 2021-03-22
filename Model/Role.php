<?php

class Role extends AppModel {

    public $name = 'Role';
    public $useTable = 'roles';
    public $actsAs = array('Containable');
    public $hasMany = array('User' => array(
            'className' => 'User',
            'foreignKey' => 'categoria'));

}

?>
