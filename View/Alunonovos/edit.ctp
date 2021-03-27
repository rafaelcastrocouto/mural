<?php

// pr($this->data); ?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#AlunonovoRegistro").mask("999999999");
        $("#AlunonovoCpf").mask("999999999-99");
        $("#AlunonovoTelefone").mask("9999.9999");
        $("#AlunonovoCelular").mask("99999.9999");
        $("#AlunonovoCep").mask("99999-999");

    });

</script>

<div class='table-responsive'>
<?= $this->element('submenu_alunonovos') ?>

    <h2>Editar alunos novos</h2>

<?php
echo $this->Form->create('Alunonovo', [
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

if ($this->Session->read('id_categoria') == '1'):
  echo $this->Form->input('registro', ['type' => 'text']);
else:
  echo $this->Form->input('registro', ['type' => 'text', 'readonly']);
endif;
echo $this->Form->input('nome');
echo $this->Form->input('nascimento', array('label'=>['text' => 'Data de nascimento', 'class' => 'col-4'], 'dateFormat'=>'DMY', 'monthNames' => $meses, 'minYear'=>'1910', 'empty'=>TRUE, 'between' => "<div class = 'form-inline col-8'>"));
echo $this->Form->input('cpf');
echo $this->Form->input('identidade');
echo $this->Form->input('orgao');
echo $this->Form->input('email');
echo $this->Form->input('codigo_telefone', array('default'=>21));
echo $this->Form->input('telefone');
echo $this->Form->input('codigo_celular', array('default'=>21));
echo $this->Form->input('celular');
echo $this->Form->input('cep');
echo $this->Form->input('endereco');
echo $this->Form->input('bairro');
echo $this->Form->input('municipio', array('default'=>'Rio de Janeiro'));
echo $this->Form->input('id', array('type'=>'hidden'));
?>
    <div class='row justify-content-center'>
        <div class='col-auto'>
<?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
        </div>
    </div>
</div>