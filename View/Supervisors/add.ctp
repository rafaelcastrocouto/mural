<?php ?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#SupervisorCpf").mask("999999999-99");
        $("#SupervisorTelefone").mask("9999.9999");
        $("#SupervisorCelular").mask("99999.9999");
        $("#SupervisorCep").mask("99999-999");

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
        $("#SupervisorCep").blur(function () {

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
                    $("#SupervisorEndereco").val("...");
                    $("#SupervisorBairro").val("...");
                    $("#SupervisorMunicipio").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");
                    //Consulta o webservice viacep.com.br/

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#SupervisorEndereco").val(dados.logradouro);
                            $("#SupervisorBairro").val(dados.bairro);
                            $("#SupervisorMunicipio").val(dados.localidade);
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

    <?= $this->element('submenu_supervisores') ?>

    <?php
    echo $this->Form->create('Supervisor', [
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => [
            'format' => ['before', 'label', 'between', 'input', 'error', 'after'],
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-3'],
            'between' => "<div class = 'col-8'>",
            'class' => ['form-control'],
            'after' => "</div>",
            'error' => false
        ]
    ]);

    echo $this->Form->input('regiao', array('default' => 7));
    echo $this->Form->input('cress');
    echo $this->Form->input('nome');
    echo $this->Form->input('cpf');
    echo $this->Form->input('codigo_tel', array('default' => 21));
    echo $this->Form->input('telefone');
    echo $this->Form->input('codigo_cel', array('default' => 21));
    echo $this->Form->input('celular');
    echo $this->Form->input('email');
    echo $this->Form->input('cep');
    echo $this->Form->input('endereco');
    echo $this->Form->input('bairro');
    echo $this->Form->input('municipio');
    echo $this->Form->input('escola');
    echo $this->Form->input('ano_formatura');
    echo $this->Form->input('outros_estudos');
    echo $this->Form->input('area_curso');
    echo $this->Form->input('ano_curso');
    echo $this->Form->input('observacoes', array('textarea', array('rows' => 5, 'cols' => 60)));
    echo $this->Form->input('Instituicao.id', array('label' => ['text' => 'Instituição', 'class' => 'col-3'], 'options' => $instituicoes, 'default' => 0));
    ?>
    <div class='row justify-content-center'>
        <div class='col-auto'>
            <?php
            echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-3'], 'class' => 'btn btn-primary']);
            ?>
            <?php
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>