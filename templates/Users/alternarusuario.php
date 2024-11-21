<?php

declare(strict_types=1);

$categoria_id = 0;
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $categoria_id = $user_session->get('categoria_id'); }
    
?>

<?php if ($categoria_id == 1): ?>

    <?= $this->Html->link('Configurações', '/configuracaos/view/1', ['role' => 'button', 'class' => 'button']) ?>
    <?= $this->Html->link('Lista de usuários', '/users/listausuarios/', ['role' => 'button', 'class' => 'button']) ?>
    <?= $this->Html->link('Usuários', '/users/index/', ['role' => 'button', 'class' => 'button']) ?>
    <?= $this->Html->link('Busca por numero', '/users/busca_numero', ['role' => 'button', 'class' => 'button']) ?>
    <?= $this->Html->link('Busca por Email', '/users/busca_email', ['role' => 'button', 'class' => 'button']) ?>
    <?= $this->Html->link('Alterna usuário', '/users/alternarusuario', ['role' => 'button', 'class' => 'button']) ?>

<?php endif; ?>

<?php
echo $this->Form->create();
echo $this->Form->input('categoria', ['label' => ['text' => 'Selecione', 'class' => 'label-control col-2'], 'options' => ['2' => 'Estudante', '3' => 'Professor', '4' => 'Supervisor'], 'empty' => 'Seleciona', 'class' => 'form-control']);
echo $this->Form->input('numero', ['label' => ['text' => 'DRE, SIAPE ou CRESS respectivamente', 'class' => 'label-control col-2'], 'class' => 'form-control']);
?>

<div class='row justify-content-between'>
    <div class='col-auto'>
<?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'button']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
