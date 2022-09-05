<script>
    $(document).ready(function () {
        $("#AlunonovoRegistro").mask("999999999");
    });
</script>

<?= $this->element('submenu_alunonovos') ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunonovos/busca', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunonovos/busca_dre', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por Email', '/alunonovos/busca_email', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunonovos/busca_cpf', ['role' => 'button', 'class' => 'btn btn-info']); ?>
    </p>
<?php endif; ?>

<?php echo $this->Form->create('Alunonovo'); ?>
<?php if ($this->Session->read('id_categoria') == '2'): ?>
    <?php echo $this->Form->input('registro', array('label' => 'Digite o DRE do aluno', 'value' => $this->Session->read('numero'), 'readonly', 'maxsize' => 9, 'class' => 'form-control')); ?>
<?php else: ?>
    <?php echo $this->Form->input('registro', array('label' => 'Digite o DRE do aluno', 'placeholder' => 'Digite o DRE', 'maxsize' => 9, 'class' => 'form-control')); ?>
<?php endif; ?>
<div class='row justify-content-between'>
    <div class='col-auto'>
        <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
