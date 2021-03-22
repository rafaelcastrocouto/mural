<?php ?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#EstagiarioRegistro").mask("999999999");

    });

</script>

<div class='table-responsive'>

    <?= $this->element('submenu_estagiarios') ?>

    <?php
    echo $this->Form->create('Estagiario', [
        'class' => 'form-inline',
        'role' => 'form',
        'inputDefaults' => [
            'format' => ['before', 'label', 'between', 'input', 'error', 'after'],
            'label' => ['class' => 'col-4'],
            'class' => ['form-control'],
            'error' => false
        ]
    ]);
    ?>
    <fieldset>
        <?= $this->Form->input('registro', ['type' => 'text', 'div' => 'col', 'label' => ['text' => 'Registro', 'style' => 'display:inline']]) ?>
    </fieldset>
    <?= $this->Form->input('Confirma', ['type' => 'Submit', 'div' => 'row', 'label' => ['text' => false, 'class' => 'col-4'], 'class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

</div>
