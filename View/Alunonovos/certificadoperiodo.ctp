<?php
// pr($estudante);
?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#AlunonovoPeriodoacademico").mask("9999-9");
        $("#AlunonovoIngresso").mask("9999-9");
    });

</script>

<div class='table-responsive'>

    <?= $this->element('submenu_alunonovos') ?>

    <h2>Declaração de periódo em curso</h2>

    <?php
    echo $this->Form->create('Alunonovo', [
        'url' => ['controller' => 'Alunonovos', 'action' => 'declaracaoperiodopdf', $estudante['Alunonovo']['id'], 'ext' => 'pdf', 'declaracaoperiodopdf'],
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => [
            'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-2'],
            'between' => "<div class = 'col-8'>",
            'class' => ['form-control'],
            'after' => "</div>",
            'error' => false
        ]
    ]);

    echo $this->Form->input('periodoacademico', ['label' => ['text' => 'Período no calendário acadêmico atual', 'class' => 'col-2 control-label'], 'value' => $periodocalendarioacademico, 'required']);

    echo $this->Form->input('nome', ['label' => ['text' => 'Nome', 'class' => 'col-2 control-label'], 'value' => $estudante['Alunonovo']['nome'], 'readonly']);

    echo $this->Form->input('nomesocial', ['type' => 'hidden', 'value' => $estudante['Alunonovo']['nomesocial']]);
    echo $this->Form->input('email', ['type' => 'hidden', 'value' => $estudante['Alunonovo']['email']]);
    echo $this->Form->input('endereco', ['type' => 'hidden', 'value' => $estudante['Alunonovo']['endereco']]);
    echo $this->Form->input('bairro', ['type' => 'hidden', 'value' => $estudante['Alunonovo']['bairro']]);

    echo $this->Form->input('registro', ['type' => 'text', 'value' => $estudante['Alunonovo']['registro'], 'readonly']);

    if (empty($estudante['Alunonovo']['ingresso']) || strlen($estudante['Alunonovo']['ingresso'] < 6)):
        echo $this->Form->input('ingresso', ['label' => ['text' => 'Ano e semestre de ingresso no curso', 'class' => 'col-2 control-label'], 'required']);
    else:
        echo $this->Form->input('ingresso', ['label' => ['text' => 'Ano e semestre de ingresso no curso', 'class' => 'col-2 control-label'], 'value' => $estudante['Alunonovo']['ingresso'], 'required', 'readonly']);
    endif;

    if (empty($estudante['Alunonovo']['turno'])):
        echo $this->Form->input('turno', ['label' => ['text' => 'Turno', 'class' => 'col-2 control-label'], 'options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno'], 'empty' => 'Seleciona', 'required']);
    else:
        echo $this->Form->input('turno', ['label' => ['text' => 'Turno', 'class' => 'col-2 control-label'], 'value' =>$estudante['Alunonovo']['turno'], 'readonly', 'required']);
    endif;

    if (empty($estudante['Alunonovo']['cpf'])):
        echo $this->Form->input('cpf', ['label' => ['text' => 'CPF', 'class' => 'col-2 control-label'], 'value' => $estudante['Alunonovo']['cpf'], 'required']);
    else:
        echo $this->Form->input('cpf', ['label' => ['text' => 'CPF', 'class' => 'col-2 control-label'], 'value' => $estudante['Alunonovo']['cpf'], 'readonly']);
    endif;

    if (empty($estudante['Alunonovo']['identidade'])):
        echo $this->Form->input('identidade', ['label' => ['text' => 'Carteira de identidade', 'class' => 'col-2 control-label'], 'value' => $estudante['Alunonovo']['identidade'], 'required']);
    else:
        echo $this->Form->input('identidade', ['label' => ['text' => 'Carteira de identidade', 'class' => 'col-2 control-label'], 'value' => $estudante['Alunonovo']['identidade'], 'readonly']);
    endif;

    if (empty($estudante['Alunonovo']['identidade'])):
        echo $this->Form->input('orgao', ['label' => ['text' => 'Orgão', 'class' => 'col-2 control-label'], 'value' => $estudante['Alunonovo']['orgao'], 'required']);
    else:
        echo $this->Form->input('orgao', ['label' => ['text' => 'Orgão', 'class' => 'col-2 control-label'], 'value' => $estudante['Alunonovo']['orgao'], 'readonly']);
    endif;

    echo $this->Form->input('id', ['type' => 'hidden', 'value' => $estudante['Alunonovo']['id']]);
    ?>
    <div class='row justify-content-center'>
        <div class='btn-group' role='group'>
            <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'role' => 'button', 'class' => 'btn btn-primary mr-1']) ?>
            <?= $this->Html->link('Alterar dados', ['controller' => 'Alunonovos', 'action' => 'edit', $estudante['Alunonovo']['id']], ['role' => 'button', 'type' => 'button', 'class' => 'btn btn-danger']); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
