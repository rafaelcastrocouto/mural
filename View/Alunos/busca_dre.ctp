
<?= $this->Html->script("jquery.maskedinput"); ?>

<script>
    $(document).ready(function () {
        $("#AlunoRegistro").mask("999999999");
    });
</script>

<?= $this->element('submenu_alunos'); ?>

<?php if ($id_categoria === '1'): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunos/busca'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunos/busca_dre'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por Email', '/alunos/busca_email'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunos/busca_cpf'); ?>
    </p>
<?php endif; ?>

<h1>Folha de atividades</h1>

<?php echo $this->Form->create('Aluno', ['class' => 'form-inline']); ?>
<?php if ($id_categoria === '2'): ?>
    <?= $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row', 'label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'value' => $this->Session->read('numero'), 'readonly', 'placeholder' => 'Digite o DRE', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control required']) ?>
<?php else: ?>
    <?= $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row', 'label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'placeholder' => 'Digite o DRE', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control required']) ?>
<?php endif; ?>
<div class='row justify-content-between'>
    <div class='col-auto'>
        <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
