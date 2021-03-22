<?php ?>

<?= $this->Html->script("jquery.maskedinput") ?>

<script>

    $(document).ready(function () {

        $("#SupervisorTelefone").mask("9999.9999");
        $("#SupervisorCelular").mask("99999.9999");

    });

</script>

<div class='table-responsive'>

    <?= $this->element('submenu_alunos') ?>

    <table class='table table-hover table-striped table-responsive'>
        <tr>
            <td>Estudante:</td><td><?php echo $aluno; ?></td>
        </tr>
        <tr>
            <td>Registro:</td><td><?php echo $registro; ?></td>
        </tr>
        <tr>
            <td>Período:</td><td><?php echo $periodo; ?></td>
        </tr>
        <tr>
            <td>Nível:</td><td><?php echo $nivel; ?></td>
        </tr>
        <tr>
            <td>Professor:</td><td><?php echo $professor; ?></td>
        </tr>
        <tr>
            <td>Instituição:</td><td><?php echo $instituicao; ?></td>
        </tr>
        <tr>
            <td>Supervisor:</td><td><?php echo $supervisor; ?></td>
        </tr>
    </table>

</div>

<h1>Preencha todos os campos do formulário</h1>

<?php
// die();
echo $this->Form->create('Supervisor', [
  'class' => 'form-horizontal',
  'role' => 'form',
    'inputDefaults' => [
        'format' => ['before', 'label', 'between', 'input', 'error', 'after'],
        'div' => ['class' => 'form-group row'],
        'label' => ['class' => 'col-4'],
        'between' => "<div class = 'col-8'>",
        'class' => ['form-control'],
        'after' => "</div>",
        'error' => false
    ]
]);

echo $this->Form->input('regiao', array('label' => ['text' => 'Região', 'class' => 'col-4'], 'default'=>7));
echo $this->Form->input('cress');
echo $this->Form->input('nome');
?>

<?php
echo $this->Form->input('codigo_tel', array('value'=>21));
echo $this->Form->input('telefone');
echo $this->Form->input('codigo_cel', array('value'=>21));
echo $this->Form->input('celular');
echo $this->Form->input('email');
?>

<?php
echo $this->Form->input('registro', array('type' => 'hidden', 'value' => $registro));
echo $this->Form->input('supervisor_id', array('type' => 'hidden', 'value' => $supervisor_id));
?>

<div class='row justify-content-center'>
    <div class='col-auto'>
    <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end(); ?>
    </div>
</div>
