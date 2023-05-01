<?php // pr($periodos);         ?>
<?php // pr($aluno);         ?>
<?php // pr($id);         ?>

<?php /* echo $this->Html->script("jquery.maskedinput"); */ ?>
<?php echo $this->Html->script("jquery.mask.min"); ?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Instituicaos', 'action' => 'seleciona_supervisor')); ?>";
        /* alert(base_url); */

        $("#EstagiarioIdInstituicao").change(function () {
            var id_instituicao = $(this).val();
            $("#EstagiarioIdSupervisor").load(base_url + "/" + id_instituicao, {id: $(this).val(), ajax: "true"});
            /* alert(id_instituicao); */
        })

    });

    $(document).ready(function () {

        /* $("#EstagiarioNota").mask("00.00", {reverse: true, placeholder: "__.__"});*/
        $("#EstagiarioCh").mask("000", {placeholder: "___"});
        $("#EstagiarioNota").mask("99.99", {reverse:true, placeholder: "__.__"});
        /*
         $("#EstagiarioNota").mask("99,99");
         $("#EstagiarioCh").mask("999");
         */
    });

</script>

<?= $this->element('submenu_estagiarios') ?>

<h2><?php echo $aluno; ?></h2>

<?php
echo $this->Form->create('Estagiario', [
    'class' => 'form-horizontal was-validated',
    'role' => 'form',
    'inputDefaults' => [
        'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
        'div' => ['class' => 'form-group row'],
        'label' => ['class' => 'col-3'],
        'between' => "<div class = 'col-7'>",
        'class' => ['form-control'],
        'after' => '</div>',
        'error' => '<div class="invalid-feedback">Digite um valor correto neste campo.</div>'
    ]
]);
?>

<?php echo $this->Form->input('Estagiario.periodo', array('label' => ['text' => 'Período', 'class' => 'col-4'], 'options' => $periodos)); ?>
<?php echo $this->Form->input('Estagiario.complemento_id', array('label' => ['text' => 'Complemento período especial', 'class' => 'col-4'], 'options' => $complemento_periodo_especial_total, 'empty' => ['Seleciona'])); ?>
<?php echo $this->Form->input('Estagiario.nivel', array('label' => ['text' => 'Nível', 'class' => 'col-4'], 'options' => array('1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '9' => 'Não obrigatório'))); ?>
<?php echo $this->Form->input('Estagiario.turno', array('label' => ['text' => 'Turno', 'class' => 'col-4'], 'options' => array('D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido'))); ?>
<?php echo $this->Form->input('Estagiario.ajuste2020', array('label' => ['text' => 'Ajuste 2020', 'class' => 'col-4'], 'options' => array('0' => 'Não', '1' => 'Sim'))); ?>
<?php echo $this->Form->input('Estagiario.tc', array('label' => ['text' => 'TC (Aluno entrogou o TC assinado na Coordenação de Estágio?', 'class' => 'col-4'], 'options' => array('0' => 'Não', '1' => 'Sim'))); ?>
<?php echo $this->Form->input('Estagiario.tc_solicitacao', array('type' => 'hidden', 'label' => ['text' => 'Data de solicitação do TC', 'class' => 'col-4'], 'dateFormat' => 'DMY', 'empty' => TRUE)); ?>
<?php echo $this->Form->input('Estagiario.benetransporte', array('label' => ['text' => 'Transporte', 'class' => 'col-4'], 'options' => ['0' => 'Não', '1' => 'Sim'])); ?>
<?php echo $this->Form->input('Estagiario.benealimentacao', array('label' => ['text' => 'Alimentação', 'class' => 'col-4'], 'options' => ['0' => 'Não', '1' => 'Sim'])); ?>
<?php echo $this->Form->input('Estagiario.benebolsa', array('label' => ['text' => 'Bolsa (digite o valor em números inteiros ou o número 0)', 'class' => 'col-4'])); ?>
<?php echo $this->Form->input('Estagiario.id_instituicao', array('label' => ['text' => 'Instituição', 'class' => 'col-4'], 'options' => $instituicoes, 'empty' => ['0' => 'Seleciona'])); ?>
<?php echo $this->Form->input('Estagiario.id_supervisor', array('label' => ['text' => 'Supervisor', 'class' => 'col-4'], 'options' => $supervisores, 'empty' => ['0' => 'Seleciona'])); ?>
<?php echo $this->Form->input('Estagiario.id_professor', array('label' => ['text' => 'Professor', 'class' => 'col-4'], 'options' => $professores, 'empty' => ['0' => 'Seleciona'])); ?>
<?php echo $this->Form->input('Estagiario.id_area', array('label' => ['text' => 'Área temática', 'class' => 'col-4'], 'options' => $areas, 'empty' => ['0' => 'Seleciona'])); ?>
<?php echo $this->Form->input('Estagiario.id_aluno', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('Estagiario.nota', ['type' => 'number', 'step' => '0.01', 'min' => '0', 'max' => '10', 'label' => ['text' => 'Nota', 'class' => 'col-4']]); ?>
<?php echo $this->Form->input('Estagiario.ch', array('type' => 'text', 'label' => ['text' => 'Carga horária (Digitar números inteiros)', 'class' => 'col-4'])); ?>
<?php echo $this->Form->input('Estagiario.observacoes', array('label' => ['text' => 'Observações', 'class' => 'col-4'])); ?>
<?php echo $this->Form->input('Estagiario.id', array('type' => 'hidden', 'value' => $id)); ?>
<div class='row justify-content-center'>
    <div class="col-auto">
        <?php echo $this->Form->input('Atualizar', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-primary position-static']); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
