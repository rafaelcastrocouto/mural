<?php

echo $this->Form->create('User', ['class' => 'form-horizontal']);
echo $this->Form->input('email', ['div' => 'form-group row', 'label' => ['text' => 'E-mail', 'class' => 'col-form-label col-4'], 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
echo $this->Form->input('categoria', ['div' => 'form-group row', 'label' => ['text' => 'Categoria: 2: Aluno, 3: Professor, 4: Supervisor', 'class' => 'col-form-label col-4'], 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
echo $this->Form->input('numero', ['div' => 'form-group row', 'label' => ['Digite o DRE, SIAPE, CRESS para estudante, professor ou supervisor respectivamente', 'class' => 'col-form-label col-4'], 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);

echo $this->Form->input('id', array('type' => 'hidden', ['class' => 'form-control']));
echo $this->Form->input('password', array('type' => 'hidden', ['class' => 'form-control']));
echo $this->Form->input('estudante_id', array('type' => 'hidden', ['class' => 'form-control']));
// echo $this->Form->input('alunonovo_id', array('type' => 'hidden', ['class' => 'form-control']));
echo $this->Form->input('docente_id', array('type' => 'hidden', ['class' => 'form-control']));
echo $this->Form->input('supervisor_id', array('type' => 'hidden', ['class' => 'form-control']));

?>

<div class='row justify-content-left'>
    <div class='col-auto'>
        <?php echo $this->Form->submit('Atualizar', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>