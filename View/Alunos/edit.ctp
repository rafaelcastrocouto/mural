<?php // pr($this->data['Aluno']['id']);  ?>

<?php
echo $this->Html->script("jquery.maskedinput");
?>

<script>

    $(document).ready(function () {

        $("#AlunoRegistro").mask("999999999");
        $("#AlunoIngresso").mask("9999-9");
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
        'class' => 'form-horizontal was-validated',
        'role' => 'form',
        'inputDefaults' => [
            'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
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
    echo $this->Form->input('nomesocial', ['label' => ['text' => 'Nome social', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('nascimento', array('label' => ['text' => 'Data de nascimento', 'class' => 'col-4 control-label'], 'dateFormat' => 'DMY', 'minYear' => '1910', 'monthNames' => $meses, 'empty' => TRUE, 'between' => "<div class = 'form-inline col-8'>"));
    echo $this->Form->input('ingresso', ['label' => ['text' => 'Ano e semestre de ingresso', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('turno', ['label' => ['text' => 'Turno', 'class' => 'col-4 control-label'], 'options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno'], 'empty' => 'Seleciona']);
    echo $this->Form->input('cpf');
    echo $this->Form->input('identidade');
// echo $this->Form->input('orgao');
    echo "<div class='form-group row' form-type='text'>";
    echo "<label for='AlunoOrgao' class='col-4 control-label'>Orgão expedidor</label>";
    echo "<div class='col-8'>";
    echo "<input list='orgaos' name= 'data[Aluno][orgao]' id='AlunonovoOrgao' value='" . $e_orgao['Aluno']['orgao'] . "' class='form-control' maxlength='30'></input>";
    echo "<small>Selecione ou digite o orgão</small>";
    echo "<datalist id='orgaos'>";
    foreach ($orgaos as $c_orgao) {
        echo "<option value='" . $c_orgao . "'>";
    };
    echo "</datalist>";
    echo "</div>";
    echo "</div>";

    echo $this->Form->input('email');
    echo $this->Form->input('codigo_telefone', array('value' => 21));
    echo $this->Form->input('telefone');
    echo $this->Form->input('codigo_celular', array('value' => 21));
    echo $this->Form->input('celular');
    echo $this->Form->input('cep');
    echo $this->Form->input('endereco', array('label' => ['text' => 'Endereço', 'class' => 'col-4']));
    echo $this->Form->input('bairro');
    echo $this->Form->input('municipio', array('value' => 'Rio de Janeiro, RJ'));
    echo $this->Form->input('id', array('type' => 'hidden'));
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