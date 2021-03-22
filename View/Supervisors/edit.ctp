<?php ?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#SupervisorCpf").mask("999999999-99");
        $("#SupervisorTelefone").mask("9999.9999");
        $("#SupervisorCelular").mask("99999.9999");
        $("#SupervisorCep").mask("99999-999");

    });

</script>

<div class="table-responsive">

    <?= $this->element('submenu_supervisores') ?>

    <?php
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
    echo $this->Form->input('regiao', array('value' => 7));
    echo $this->Form->input('cress');
    echo $this->Form->input('nome');
    echo $this->Form->input('cpf');
    echo $this->Form->input('codigo_tel', array('value' => 21));
    echo $this->Form->input('telefone');
    echo $this->Form->input('codigo_cel', array('value' => 21));
    echo $this->Form->input('celular');
    echo $this->Form->input('email');
    echo $this->Form->input('endereco');
    echo $this->Form->input('cep');
    echo $this->Form->input('bairro');
    echo $this->Form->input('municipio');
    echo $this->Form->input('escola');
    echo $this->Form->input('ano_formatura');
    echo $this->Form->input('outros_estudos');
    echo $this->Form->input('area_curso');
    echo $this->Form->input('ano_curso');
    echo $this->Form->input('observacoes', array('textarea', array('rows' => 5, 'cols' => 60)));
    ?>
    <div class = 'row justify-content-center'>
        <div class = 'col-auto'>
            <?php
            echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
            ?>
            <?php
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>