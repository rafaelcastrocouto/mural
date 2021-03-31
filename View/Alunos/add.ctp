<?php
// pr($alunonovo);
?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#AlunoRegistro").mask("999999999");
        $("#AlunoCpf").mask("999999999-99");
        $("#AlunoTelefone").mask("9999.9999");
        $("#AlunoCelular").mask("99999.9999");
        $("#AlunoCep").mask("99999-999");

    });

    /* Adicionando Javascript para busca de CEP */
    $(document).ready(function () {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#AlunoEndereco").val("");
            $("#AlunoBairro").val("");
            $("#AlunoMunicipio").val("");
            $("#uf").val("");
            $("#ibge").val("");
        }

//Quando o campo cep perde o foco.
        $("#AlunoCep").blur(function () {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
                /* alert(cep); */
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;
                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#AlunoEndereco").val("...");
                    $("#AlunoBairro").val("...");
                    $("#AlunoMunicipio").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");
                    //Consulta o webservice viacep.com.br/

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#AlunoEndereco").val(dados.logradouro);
                            $("#AlunoBairro").val(dados.bairro);
                            $("#AlunoMunicipio").val(dados.localidade);
                            $("#uf").val(dados.uf);
                            $("#ibge").val(dados.ibge);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else
                {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }

            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });
    });

</script>

<?= $this->element('submenu_alunos') ?>

<?php echo $this->Html->link('Listar', '/Alunos/index/'); ?>

<?php
/*
 * O cadastro do aluno pode receber a informacao da tabela alunonovo
 */

if (!isset($alunonovo['Alunonovo']['nome']))
    $alunonovo['Alunonovo']['nome'] = NULL;
if (!isset($alunonovo['Alunonovo']['registro']))
    $alunonovo['Alunonovo']['registro'] = NULL;
if (!isset($registro))
    $registro = NULL;
if (!isset($alunonovo['Alunonovo']['nascimento']))
    $alunonovo['Alunonovo']['nascimento'] = NULL;
if (!isset($alunonovo['Alunonovo']['cpf']))
    $alunonovo['Alunonovo']['cpf'] = NULL;
if (!isset($alunonovo['Alunonovo']['identidade']))
    $alunonovo['Alunonovo']['identidade'] = NULL;
if (!isset($alunonovo['Alunonovo']['orgao']))
    $alunonovo['Alunonovo']['orgao'] = NULL;
if (!isset($alunonovo['Alunonovo']['email']))
    $alunonovo['Alunonovo']['email'] = NULL;
if (!isset($alunonovo['Alunonovo']['codigo_telefone']))
    $alunonovo['Alunonovo']['codigo_telefone'] = 21;
if (!isset($alunonovo['Alunonovo']['telefone']))
    $alunonovo['Alunonovo']['telefone'] = NULL;
if (!isset($alunonovo['Alunonovo']['codigo_celular']))
    $alunonovo['Alunonovo']['codigo_celular'] = NULL;
if (!isset($alunonovo['Alunonovo']['celular']))
    $alunonovo['Alunonovo']['celular'] = NULL;
if (!isset($alunonovo['Alunonovo']['endereco']))
    $alunonovo['Alunonovo']['endereco'] = NULL;
if (!isset($alunonovo['Alunonovo']['bairro']))
    $alunonovo['Alunonovo']['bairro'] = NULL;
if (!isset($alunonovo['Alunonovo']['municipio']))
    $alunonovo['Alunonovo']['municipio'] = NULL;
if (!isset($alunonovo['Alunonovo']['cep']))
    $alunonovo['Alunonovo']['cep'] = NULL;
?>

<h1>Inserir aluno</h1>

<?php
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
?>

<fieldset>
    <legend>Dados do aluno</legend>

    <table class="table table-hover table-striped table-responsive">
        <tr>
            <td colspan="2">
                <?php echo $this->Form->input('nome', array('value' => $alunonovo['Alunonovo']['nome'])); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $this->Form->input('registro', array('type' => 'text', 'value' => $registro, 'size' => '9', 'maxLenght' => '9')); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo $this->Form->input('nascimento', array('label' => ['text' => 'Data de nascimento', 'class' => 'col-4'], 'value' => $alunonovo['Alunonovo']['nascimento'], 'dateFormat' => 'DMY', 'minYear' => '1910', 'empty' => TRUE, 'between' => "<div class = 'form-inline col-8'>")); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
<?php // echo $this->Form->input('cpf', array('value'=>$alunonovo['Alunonovo']['cpf']));  ?>
            </td>
        </tr>

        <tr>
            <td>
<?php echo $this->Form->input('identidade', array('label' => ['text' => 'Cartera de identidade', 'class' => 'col-4'], 'value' => $alunonovo['Alunonovo']['identidade'])); ?>
            </td>
            <td>
                <?php echo $this->Form->input('orgao', array('label' => 'Orgão', 'legend' => false, 'value' => $alunonovo['Alunonovo']['orgao'])); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
<?php echo $this->Form->input('email', array('value' => $alunonovo['Alunonovo']['email'])); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $this->Form->input('codigo_telefone', array('default' => 21, 'value' => $alunonovo['Alunonovo']['codigo_telefone'])); ?>
            </td>
            <td>
<?php echo $this->Form->input('telefone', array('value' => $alunonovo['Alunonovo']['telefone'])); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $this->Form->input('codigo_celular', array('default' => 21, 'value' => $alunonovo['Alunonovo']['codigo_celular'])); ?>
            </td>
            <td>
<?php echo $this->Form->input('celular', array('value' => $alunonovo['Alunonovo']['celular'])); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php echo $this->Form->input('cep', array('value' => $alunonovo['Alunonovo']['cep'], 'required')); ?>
            </td>
            <td>
<?php echo $this->Form->input('endereco', array('label' => 'Endereço', 'value' => $alunonovo['Alunonovo']['endereco'])); ?>
            </td>
        </tr>

        <tr>
            <td>
        <?php echo $this->Form->input('bairro', array('value' => $alunonovo['Alunonovo']['bairro'])); ?>
            </td>
            <td>
        <?php echo $this->Form->input('municipio', array('value' => $alunonovo['Alunonovo']['municipio'], 'default' => 'Rio de Janeiro, RJ')); ?>
            </td>
        </tr>

    </table>

</fieldset>

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
