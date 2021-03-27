<?php if ($id_categoria == '1'): ?>
    <p>
        <?= $this->Html->link('Busca por número', '/users/busca_numero') ?>
        <?= " | " ?>
        <?= $this->Html->link('Busca por Email', '/users/busca_email') ?>
        <?= " | " ?>
        <?= $this->Html->link('Usuários', '/users/listausuarios') ?>
        <?= " | " ?>
        <?= $this->Html->link('Alterna usuário', '/users/alternarusuario') ?>
    </p>
<?php endif; ?>

<?php
echo $this->Form->create('User', ['class' => 'form-horizontal']);
echo $this->Form->input('categoria', ['div' => 'form-group row', 'label' => ['text' => 'Selecione', 'class' => 'label-control col-2'], 'options' => ['2' => 'Estudante', '3' => 'Professor', '4' => 'Supervisor'], 'empty' => 'Seleciona', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
echo $this->Form->input('numero', ['div' => 'form-group row', 'label' => ['text' => 'DRE, SIAPE ou CRESS respectivamente', 'class' => 'label-control col-2'], 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
?>

<div class='row justify-content-between'>
    <div class='col-auto'>
<?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
