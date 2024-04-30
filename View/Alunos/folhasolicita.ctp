<?=
$this->Html->script("jquery.maskedinput");
?>

<script>

    $(document).ready(function () {

        $("#AlunoRegistro").mask("999999999");

    });

</script>

<?= $this->element('submenu_alunos') ?>

<h1>Folha de atividades</h1>

<?php
echo $this->Form->create('Aluno', ['class' => 'form-inline']);
if ($this->Session->read('id_categoria') != '2') {
    echo $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row','label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'placeholder' => 'Digite o DRE', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>','class' => 'form-control required']);
} else {
    echo $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row','label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'value' => $this->Session->read('numero'), 'between' => '<div class ="form-inline col-8">', 'after' => '</div>','class' => 'form-control required']);
}
    ?>
<div class='row justify-content-left'>
    <div class='col-auto'>
        <?php
        echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
        echo $this->Form->end();
        ?>
    </div>
</div>
