<?php
// pr($this->data);
?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#AlunonovoRegistro").mask("999999999");
        $("#AlunonovoIngresso").mask("9999-9");
        $("#AlunonovoCpf").mask("999999999-99");
        $("#AlunonovoTelefone").mask("9999.9999");
        $("#AlunonovoCelular").mask("99999.9999");
        $("#AlunonovoCep").mask("99999-999");

    });

    $(document).ready(function () {
        /* Adicionando Javascript para busca de CEP */
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

<div class='table-responsive'>

    <?= $this->element('submenu_alunonovos') ?>

    <h2>Editar estudante</h2>

    <?php
    echo $this->Form->create('Alunonovo', [
        'class' => 'form-horizontal',
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

    /* Acrescento um 0 no registro para visualização */
    if (strlen($this->data['Alunonovo']['registro']) == 8) {
        $this->request->data['Alunonovo']['registro'] = '0' . $this->data['Alunonovo']['registro'];
    }
    if ($this->Session->read('id_categoria') == '1'):
        echo $this->Form->input('registro', ['type' => 'text']);
    else:
        echo $this->Form->input('registro', ['type' => 'text', 'readonly']);
    endif;
    echo $this->Form->input('nome');
    echo $this->Form->input('nomesocial', ['label' => ['text' => 'Nome social', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('nascimento', ['label' => ['text' => 'Data de nascimento', 'class' => 'col-4 control-label'], 'dateFormat' => 'DMY', 'monthNames' => $meses, 'minYear' => '1910', 'empty' => TRUE, 'between' => "<div class = 'form-inline col-8'>"]);
    if (strlen($this->data['Alunonovo']['ingresso']) == 4) {
        $this->request->data['Alunonovo']['ingresso'] = $this->data['Alunonovo']['ingresso'] . '-0';
    }
    echo $this->Form->input('ingresso', ['label' => ['text' => 'Ano e semestre de ingresso no curso', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('turno', ['label' => ['text' => 'Turno', 'class' => 'col-4 control-label'], 'options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno'], 'empty' => 'Seleciona']);
    echo $this->Form->input('cpf', ['label' => ['text' => 'CPF', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('identidade', ['label' => ['text' => 'Carteira de identidade', 'class' => 'col-4 control-label']]);

    echo "<div class='form-group row' form-type='text'>";
    echo "<label for='AlunonovoOrgao' class='col-4 control-label'>Orgão expedidor</label>";
    echo "<div class='col-8'>";
    echo "<input list='orgaos' name= 'data[Alunonovo][orgao]' id='AlunonovoOrgao' value='" . $e_orgao['Alunonovo']['orgao'] . "' class='form-control' maxlength='30'></input>";
    echo "<small>Selecione ou digite o orgão</small>";
    echo "<datalist id='orgaos'>";
    foreach ($orgaos as $c_orgao) {
        echo "<option value='" . $c_orgao . "'>";
    };
    echo "</datalist>";
    echo "</div>";
    echo "</div>";

    echo $this->Form->input('email');
    echo $this->Form->input('codigo_telefone', array('default' => 21));
    echo $this->Form->input('telefone');
    echo $this->Form->input('codigo_celular', array('default' => 21));
    echo $this->Form->input('celular');
    echo $this->Form->input('cep', ['label' => ['text' => 'CEP', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('endereco', ['label' => ['text' => 'Endereço', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('bairro');
    echo $this->Form->input('municipio', array('default' => 'Rio de Janeiro'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    ?>
    <div class='row justify-content-center'>
        <div class='col-auto'>
            <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
