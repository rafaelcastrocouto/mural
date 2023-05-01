<?php
// pr($ingresso);
// pr($turno);
// die();
?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#InscricaoIdAluno").mask("999999999");
        $("#InscricaoIngresso").mask("9999-9");

    });

</script>

<div class='table-responsive'>

    <?= $this->element('submenu_inscricoes') ?>

    <h1 class='h2'>Digite o número de DRE</h1>
    
    <?php
    echo $this->Form->create('Inscricao', [
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => [
            'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-2'],
            'between' => "<div class = 'col-2'>",
            'class' => ['form-control'],
            'after' => "</div>",
            'error' => ['attributes' => ['wrap' => 'span', 'class' => 'help-inline']]
        ]
    ]);

    if ($this->Session->read('id_categoria') == 2) {

        echo $this->Form->input('registro', ['type' => 'text', 'label' => ['text' => 'Registro (DRE)', 'class' => 'col-2 label-control'], 'size' => 9, 'maxlenght' => 9, 'readonly', 'default' => $this->Session->read('numero'), 'class' => 'form-control']);

        if (isset($ingresso) && (strlen($ingresso) == 6)) {
            echo $this->Form->input('ingresso', ['type' => 'hidden', 'label' => ['text' => 'Ano e período de ingresso na ESS', 'class' => 'col-2 label-control'], 'required', 'readonly', 'value' => $ingresso]);
        } else {
            echo $this->Form->input('ingresso', ['type' => 'text', 'label' => ['text' => 'Ano e período de ingresso na ESS', 'class' => 'col-2 label-control'], 'required', 'value' => $ingresso]);
        }
        if (isset($turno)) {
            echo $this->Form->input('turno', ['type' => 'hidden', 'label' => ['text' => 'Qual seu turno?', 'class' => 'col-2 label-control'], 'empty' => 'Seleciona', 'required', 'readonly', 'value' => $turno]);
        } else {
            echo $this->Form->input('turno', ['type' => 'select', 'label' => ['text' => 'Qual seu turno?', 'class' => 'col-2 label-control'], 'options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno'], 'empty' => 'Seleciona', 'required', 'value' => $turno]);
        }
    } else {
        echo $this->Form->input('registro', ['type' => 'text', 'label' => ['text' => 'Registro (DRE)', 'class' => 'col-2 label-control'], 'size' => 9, 'maxlenght' => 9, 'required', 'default' => null, 'class' => 'form-control']);
    }

    echo $this->Form->input('id_instituicao', ['type' => 'hidden', 'value' => $id_instituicao]);

    ?>
    <div class='row justify-content-between'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
