<script>
$(document).ready(function(){
    $("#AlunonovoRegistro").mask("999999999");
});
</script>

<div class='table-responsive'>
    
<?= $this->element('submenu_alunonovos') ?>
    
    <p>
<?php echo $this->Html->link('Busca por Nome','/alunonovos/busca'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por DRE','/alunonovos/busca_dre'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por Email','/alunonovos/busca_email'); ?>
<?php echo " | "; ?>
<?php echo $this->Html->link('Busca por CPF','/alunonovos/busca_cpf'); ?>
</p>

<h1>Busca por DRE</h1>

<?php echo $this->Form->create('Alunonovo'); ?>
<?php echo $this->Form->input('registro', array('label'=>'Digite o DRE do aluno', 'maxsize'=>9, 'class' => 'form-control')); ?>
<div class='row justify-content-between'>
    <div class='col-auto'>
<?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
<?php echo $this->Form->end(); ?>
    </div>
</div>
</div>