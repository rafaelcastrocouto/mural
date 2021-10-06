<?= $this->element('submenu_usuarios') ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>

    <?= $this->Html->link('Configurações', '/configuracaos/view/1', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Lista de usuários', '/users/listausuarios/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Usuários', '/users/index/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por numero', '/users/busca_numero', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por Email', '/users/busca_email', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Alterna usuário', '/users/alternarusuario', ['role' => 'button', 'class' => 'btn btn-info']) ?>

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
