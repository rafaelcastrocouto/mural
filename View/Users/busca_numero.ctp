<script>
    $(document).ready(function () {
        $("#UserNumero").mask("999999999");
    });
</script>

<!--
<?= $this->element('submenu_alunonovos') ?>
//-->

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

<h1>Busca por número</h1>

<?php echo $this->Form->create('User'); ?>
<?php if ($id_categoria == '2'): ?>
    <?php echo $this->Form->input('numero', array('label' => 'Digite o DRE do aluno', 'value' => $this->Session->read('numero'), 'readonly', 'maxsize' => 9, 'class' => 'form-control')); ?>
<?php else: ?>
    <?php echo $this->Form->input('numero', array('label' => 'Digite o número', 'placeholder' => 'Digite o número', 'maxsize' => 9, 'class' => 'form-control')); ?>
<?php endif; ?>
<div class='row justify-content-between'>
    <div class='col-auto'>
        <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
