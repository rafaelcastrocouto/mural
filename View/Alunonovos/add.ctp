<?php

// pr($meses);

?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#AlunonovoRegistro").mask("999999999", {placeholder: "_"});
        $("#AlunonovoCpf").mask("999999999-99");
        $("#AlunonovoTelefone").mask("9999.9999");
        $("#AlunonovoCelular").mask("99999.9999");
        $("#AlunonovoCep").mask("99999-999");

    });

    /* Adicionando Javascript para busca de CEP */
    $(document).ready(function () {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#AlunonovoEndereco").val("");
            $("#AlunonovoBairro").val("");
            $("#AlunonovoMunicipio").val("");
            $("#uf").val("");
            $("#ibge").val("");
        }

//Quando o campo cep perde o foco.
        $("#AlunonovoCep").blur(function () {

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
                    $("#AlunonovoEndereco").val("...");
                    $("#AlunonovoBairro").val("...");
                    $("#AlunonovoMunicipio").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");
                    //Consulta o webservice viacep.com.br/

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#AlunonovoEndereco").val(dados.logradouro);
                            $("#AlunonovoBairro").val(dados.bairro);
                            $("#AlunonovoMunicipio").val(dados.localidade);
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

<?= $this->element('submenu_alunonovos'); ?>

<?php echo $this->Form->create('Alunonovo', [
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

<h1>Cadastro de estudante novo</h1>

<fieldset>
    <legend>Dados da(o) aluna(o)</legend>
    <div class='table-responsive'>
        <table class="table table-striped table-hover table-responsive">

            <!--
            Verifico que tenha um número e que seja de um estudante
            //-->
        <?php if ($this->Session->read('numero') || ($this->Session->read('id_categoria') == '2')): ?>
            <tr>
                <td colspan="2">
                    <label for="AlunonovoRegistro">Registro na UFRJ (DRE): <?php echo $this->Session->read('numero'); ?></label>
                <?php echo $this->Form->input('registro', array('type'=>'text', 'label' => ['text' => 'Registro DRE', 'class' => 'col-4'], 'value'=>$registro, 'default'=>$this->Session->read('numero'), 'readonly')); ?>
                </td>
            </tr>
            <!--
            Senão somente o administrador pode cadastrar um aluno novo
            //-->
        <?php else: ?>
            <?php echo "Cadastro realizado pelo Administrador."; ?>
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
            <tr>
                <td colspan="2">
                <?php echo $this->Form->input('registro', array('type'=>'text', 'value'=>$registro, 'default'=>$this->Session->read('numero'))); ?>
                </td>
            </tr>
            <?php endif; ?>
        <?php endif; ?>

            <tr>
                <td colspan="2">
            <?php echo $this->Form->input('nome'); ?>
                </td>
            </tr>

            <tr>
                <td colspan="2">
            <?php echo $this->Form->input('nascimento', array('label'=> ['text' =>'Data de nascimento', 'class' => 'col-4'], 'dateFormat'=>'DMY', 'monthNames' => $meses, 'minYear'=>'1910', 'empty'=>TRUE, 'between' => "<div class = 'form-inline col-8'>")); ?>
                </td>
            </tr>

            <tr>
                <td colspan="2">
            <?php echo $this->Form->input('cpf'); ?>
                </td>
            </tr>

            <tr>
                <td>
            <?php echo $this->Form->input('identidade'); ?>
                </td>
                <td>
            <?php echo $this->Form->input('orgao'); ?>
                </td>
            </tr>

        <?php if ($this->Session->read('numero') || ($this->Session->read('categoria') === 'estudante')): ?>
            <tr>
                <td colspan="2">
                    <label for="AlunonovoEmail">Email: <?php echo strtolower($this->Session->read('user')); ?></label>
            <?php echo $this->Form->input('email', array('type'=>'hidden', 'default'=>$this->Session->read('user'))); ?>
                </td>
            </tr>
        <?php else: ?>
            <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <tr>
                <td colspan="2">
                <?php echo $this->Form->input('email'); ?>
                </td>
            </tr>
            <?php endif; ?>
        <?php endif; ?>

            <tr>
                <td>
            <?php echo $this->Form->input('codigo_tel', array('default'=>21)); ?>
                </td>
                <td>
            <?php echo $this->Form->input('telefone'); ?>
                </td>
            </tr>

            <tr>
                <td>
            <?php echo $this->Form->input('codigo_cel', array('default'=>21)); ?>
                </td>
                <td>
            <?php echo $this->Form->input('celular'); ?>
                </td>
            </tr>

            <tr>
                <td>
            <?php echo $this->Form->input('cep'); ?>
                </td>

                <td>
            <?php echo $this->Form->input('endereco'); ?>
                </td>
            </tr>

            <tr>
                <td>
            <?php echo $this->Form->input('bairro'); ?>
                </td>
                <td>
            <?php echo $this->Form->input('municipio', array('default'=>'Rio de Janeiro, RJ')); ?>
                </td>
            </tr>

        </table>
    </div>
</fieldset>

<?php
if (isset($id_instituicao)) {
    echo $this->Form->input('id_instituicao', array('type'=>'hidden', 'value'=>$id_instituicao));
} else {
    echo $this->Form->input('id_instituicao', array('type'=>'hidden'));
}
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
