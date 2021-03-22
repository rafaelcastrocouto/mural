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

        var url_listainstituicao = "<?= $this->Html->url(array('controller' => 'Instituicaos', 'action' => 'listainstituicao')); ?>";
        var url_listanatureza = "<?= $this->Html->url(array('controller' => 'Instituicaos', 'action' => 'listanatureza')); ?>";
        var url_listabairro = "<?= $this->Html->url(array('controller' => 'Instituicaos', 'action' => 'listabairro')); ?>";
        /* alert(base_url); */

        $("#InstituicaoInstituicao").autocomplete(url_listainstituicao, {maxItemsToShow: 0});
        $("#InstituicaoNatureza").autocomplete(url_listanatureza);
        $("#InstituicaoBairro").autocomplete(url_listabairro, {maxItemsToShow: 0});

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

    echo $this->Form->input('instituicao');
    echo $this->Form->input('cnpj');
    echo $this->Form->input('email');
    echo $this->Form->input('url', array('label' => ['text' => 'Página web (inclua o protocolo: http://)', 'class' => 'col-4']));
    echo $this->Form->input('convenio', array('label' => ['text' => 'Número de convênio na UFRJ', 'class' => 'col-4'], 'default' => 0));
    echo $this->Form->input('expira', array('label' => ['text' => 'Expira', 'class' => 'col-4'], 'empty' => true, 'dateFormat' => 'DMY', 'monthNames' => $meses, 'between' => "<div class = 'form-inline col-8'>"));
    echo $this->Form->input('seguro', array('options' => array('0' => 'Não', '1' => 'Sim')));
    echo $this->Form->input('area_instituicoes_id', array('options' => $area_instituicao, 'empty' => true));
    echo $this->Form->input('natureza');
    echo $this->Form->input('endereco');
    echo $this->Form->input('cep');
    echo $this->Form->input('bairro');
    echo $this->Form->input('municipio');
    echo $this->Form->input('telefone');
    echo $this->Form->input('fax');
    echo $this->Form->input('beneficio');
    echo $this->Form->input('final_de_semana', array('options' => array('0' => 'Não', '1' => 'Sim', '2' => 'Parcialmente'), 'default' => 0));
    echo $this->Form->input('observacoes', array('type' => 'textarea', array('rows' => 5, 'cols' => 60)));
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