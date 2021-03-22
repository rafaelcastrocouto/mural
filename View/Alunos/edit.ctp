<?php // pr($this->data['Aluno']['id']); ?>

<?php
echo $this->Html->script("jquery.maskedinput");
?>

<script>

$(document).ready(function(){

    $("#AlunoRegistro").mask("999999999");
    $("#AlunoCpf").mask("999999999-99");
    $("#AlunoTelefone").mask("9999.9999");
    $("#AlunoCelular").mask("99999.9999");
    $("#AlunoCep").mask("99999-999");

});

</script>

<div class='table-responsive'>
<?= $this->element('submenu_alunos') ?>
    
    <h2>Editar</h2>

<?php

$hoje = date('Y-m-d', strtotime('today'));

echo $this->Form->create('Aluno', [
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
echo $this->Form->input('registro', ['type' => 'text', 'readonly']);
echo $this->Form->input('nome');
echo $this->Form->input('nascimento', array('label'=>['text' =>'Data de nascimento', 'class' => 'col-4'], 'dateFormat'=>'DMY', 'minYear'=>'1910', 'monthNames'=> $meses,  'empty'=>TRUE, 'between' => "<div class = 'form-inline col-8'>"));
echo $this->Form->input('cpf');
echo $this->Form->input('identidade');
echo $this->Form->input('orgao');
echo $this->Form->input('email');
echo $this->Form->input('codigo_telefone', array('value'=>21));
echo $this->Form->input('telefone');
echo $this->Form->input('codigo_celular', array('value'=>21));
echo $this->Form->input('celular');
echo $this->Form->input('cep');
echo $this->Form->input('endereco',array('label'=> ['text' => 'Endereço', 'class' => 'col-4']));
echo $this->Form->input('bairro');
echo $this->Form->input('municipio', array('value'=>'Rio de Janeiro, RJ'));
echo $this->Form->input('id', array('type'=>'hidden'));
?>
    
<div class='row justify-content-center'>
    <div class='col-auto'>
<?php
echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
?>
    <?php
echo $this->Form->end();
?>
    </div>
</div>

</div>