<?php ?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<?= $this->Html->script("jquery.autocomplete"); ?>
<?= $this->Html->css("jquery.autocomplete"); ?>

<script>

    $(document).ready(function () {

        $("#InstituicaoCep").mask("99999-999");
        $("#InstituicaoCnpj").mask("99.999.999/9999-99");

    });

    $(document).ready(function () {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#InstituicaoEndereco").val("");
            $("#InstituicaoBairro").val("");
            $("#InstituicaoMunicipio").val("");
            $("#uf").val("");
            $("#ibge").val("");
        }

//Quando o campo cep perde o foco.
        $("#InstituicaoCep").blur(function () {

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
                    $("#InstituicaoEndereco").val("...");
                    $("#InstituicaoBairro").val("...");
                    $("#InstituicaoMunicipio").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");
                    //Consulta o webservice viacep.com.br/

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#InstituicaoEndereco").val(dados.logradouro);
                            $("#InstituicaoBairro").val(dados.bairro);
                            $("#InstituicaoMunicipio").val(dados.localidade);
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

    <?php echo $this->element('submenu_instituicoes'); ?>

    <?php
    echo $this->Form->create('Instituicao', [
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

    // echo $this->Form->input('instituicao');
    echo "<div class='form-group row' form-type='text'>"
    . "<label class='col-4 control-label'>Instituição</label>"
    . "<div class='col-8'>"
    . "<input list='instituicoes' name= 'data[Instituicao][instituicao]' id='InstituicaoInstituicao' value='" . $e_instituicao['Instituicao']['instituicao'] . "' class='form-control' maxlength='120'></input>"
    . "<small>Digite o nome da instituição</small>"
    . "<datalist id='instituicoes'>";
    foreach ($instituicoes as $instituicao) {
        echo "<option value='" . $instituicao . "'>";
    };
    echo "</datalist>"
    . "</div>"
    . "</div>";

    echo $this->Form->input('cnpj', ['label' => ['text' => 'CNPJ', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('email', ['label' => ['text' => 'E-mail', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('url', ['label' => ['text' => 'Página web (inclua o protocolo: http://)', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('convenio', ['label' => ['text' => 'Número de convênio na UFRJ', 'class' => 'col-4 control-label'], 'default' => 0]);
    echo $this->Form->input('expira', ['label' => ['text' => 'Expira', 'class' => 'col-4 control-label'], 'empty' => true, 'dateFormat' => 'DMY', 'monthNames' => $meses, 'between' => "<div class = 'form-inline col-8'>"]);
    echo $this->Form->input('seguro', ['options' => ['0' => 'Não', '1' => 'Sim']]);
    echo $this->Form->input('area_instituicoes_id', ['label' => ['text' => 'Área da instituição', 'class' => 'col-4 control-label'], 'options' => $area_instituicao, 'empty' => true]);
    // echo $this->Form->input('natureza');

    echo "<div class='form-group row' form-type='text'>"
    . "<label class='col-4 control-label'>Natureza</label>"
    . "<div class='col-8'>"
    . "<input list='naturezas' name= 'data[Instituicao][natureza]' id='InstituicaoNatureza' value='" . $e_instituicao['Instituicao']['natureza'] . "' class='form-control' maxlength='50'></input>"
    . "<small>Digite a natureza da instituição</small>"
    . "<datalist id='naturezas'>";
    foreach ($naturezas as $natureza) {
        echo "<option value='" . $natureza . "'>";
    };
    echo "</datalist>"
    . "</div>"
    . "</div>";

    echo $this->Form->input('cep', ['label' => ['text' => 'Endereço', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('endereco', ['label' => ['text' => 'Endereço', 'class' => 'col-4 control-label']]);
    // echo $this->Form->input('bairro');
    echo "<div class='form-group row' form-type='text'>"
    . "<label class='col-4 control-label'>Bairro</label>"
    . "<div class='col-8'>"
    . "<input list='bairros' name= 'data[Instituicao][bairro]' id='InstituicaoBairro' value='" . $e_instituicao['Instituicao']['bairro'] . "'class='form-control' maxlength='50'></input>"
    . "<small>Digite o bairro</small>"
    . "<datalist id='bairros'>";
    foreach ($bairros as $bairro) {
        echo "<option value='" . $bairro . "'>";
    };
    echo "</datalist>"
    . "</div>"
    . "</div>";

    echo $this->Form->input('municipio', ['label' => ['text' => 'Benefício', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('telefone');
    echo $this->Form->input('fax');
    echo $this->Form->input('beneficio', ['label' => ['text' => 'Benefícios', 'class' => 'col-4 control-label']]);
    echo $this->Form->input('final_de_semana', ['label' => ['text' => 'Estágio final de semana', 'class' => 'col-4 control-label'], 'options' => ['0' => 'Não', '1' => 'Sim', '2' => 'Parcialmente'], 'default' => 0]);
    echo $this->Form->input('observacoes', ['label' => ['text' => 'Observações', 'class' => 'col-4 control-label'],'type' => 'textarea', ['rows' => 5, 'cols' => 60]]);
    ?>
    <div class='row justify-content-center'>
        <div class='col-auto'>
            <?php
            echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 control-label'], 'class' => 'btn btn-primary']);
            ?>
            <?php
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>