<?= $this->Html->script("jquery.maskedinput"); ?>

<script>
    $(document).ready(function () {
        $("#AlunoRegistro").mask("999999999");
    });
</script>


<?php
$categoria_id = 0;

if ($session) {
    $categoria_id = $session->get('categoria_id');
}
?>
    <?php if ($categoria_id == 1): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunos/busca', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunos/busca_dre', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por Email', '/alunos/busca_email', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunos/busca_cpf', ['role' => 'button', 'class' => 'btn btn-info']); ?>
    </p>
<?php endif; ?>

<?php echo $this->Form->create(); ?>
<?php if ($categoria_id == 2): ?>
    <?= $this->Form->input('registro', ['type' => 'text', 'label' => ['text' => 'DRE'], 'readonly', 'placeholder' => 'Digite o DRE', 'class' => 'form-control']) ?>
<?php else: ?>
    <?= $this->Form->input('registro', ['type' => 'text', 'label' => ['text' => 'DRE'], 'placeholder' => 'Digite o DRE', 'class' => 'form-control']) ?>
<?php endif; ?>
<div class='row justify-content-between'>
    <div class='col-auto'>
        <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
