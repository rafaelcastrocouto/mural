<?php

echo $this->Form->create('User');
echo $this->Form->input('role', array('label' => 'Selecione', 'options' => array('2' => 'Estudante', '3' => 'Professor', '4' => 'Supervisor'), 'class' => 'form-control'));
echo $this->Form->input('numero', array('label' => 'DRE, SIAPE ou CRESS respectivamente', 'class' => 'form-control'));
echo $this->Form->end('Confirma');

?>