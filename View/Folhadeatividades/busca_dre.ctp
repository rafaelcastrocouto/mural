<?= $this->Html->script("jquery.maskedinput"); ?>

<script>
    $(document).ready(function () {
        $("#AlunoRegistro").mask("999999999");
    });
</script>

<?= $this->element('submenu_folhadeatividades'); ?>

<h1>Folha de atividades on-line</h1>

<?= $this->Form->create('Aluno', ['class' => 'form-inline']) ?>
<?php if ($this->Session->read('id_categoria') == '2'): ?>
    <?= $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row', 'label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'value' => $this->Session->read('numero'), 'readonly', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control required']) ?>
<?php else: ?>
    <?= $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row', 'label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'placeholder' => 'Digite o DRE', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control required']) ?>
<?php endif; ?>
<div class='row justify-content-between'>
    <div class='col-auto'>
        <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
