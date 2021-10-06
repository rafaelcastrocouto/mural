<script>
    $(document).ready(function () {
        $("#UserNumero").mask("999999999");
    });
</script>

<?= $this->element('submenu_usuarios') ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>

    <?= $this->Html->link('Configurações', '/configuracaos/view/1', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Lista de usuários', '/users/listausuarios/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Usuários', '/users/index/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por numero', '/users/busca_numero', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por Email', '/users/busca_email', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Alterna usuário', '/users/alternarusuario', ['role' => 'button', 'class' => 'btn btn-info']) ?>

<?php endif; ?>

<h1>Busca por número</h1>

<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->input('numero', array('label' => 'Digite o número', 'placeholder' => 'Digite o número', 'maxsize' => 9, 'class' => 'form-control')); ?>
<div class='row justify-content-between'>
    <div class='col-auto'>
        <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
