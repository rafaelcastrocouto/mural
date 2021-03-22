<?php // pr($periodos);   ?>

<?= $this->Html->script("jquery.maskedinput"); ?>

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

        $("#EstagiarioNota").mask("99.99");
        $("#EstagiarioCh").mask("999");

    });

</script>

<div class="table-responsive">

    <?= $this->element('submenu_estagiarios') ?>

    <h2><?php echo $aluno; ?></h2>

    <?php
    echo $this->Form->create('Estagiario', [
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

    <?php echo $this->Form->input('Estagiario.periodo', array('label' => ['text' => 'Período', 'class' => 'col-4'], 'options' => $periodos)); ?>
    <?php echo $this->Form->input('Estagiario.complemento_id', array('label' => ['text' => 'Complemento período especial', 'class' => 'col-4'], 'options' => $complemento_periodo_especial_total, 'empty' => ['Seleciona'])); ?>
    <?php echo $this->Form->input('Estagiario.nivel', array('label' => ['text' => 'Nível', 'class' => 'col-4'], 'options' => array('1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '9' => 'Não obrigatório'))); ?>
    <?php echo $this->Form->input('Estagiario.turno', array('label' => ['text' => 'Turno', 'class' => 'col-4'], 'options' => array('D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido'))); ?>
    <?php echo $this->Form->input('Estagiario.tc', array('label' => ['text' => 'TC (Aluno entrogou o TC assinado na Coordenação de Estágio?', 'class' => 'col-4'], 'options' => array('0' => 'Não', '1' => 'Sim'))); ?>
    <?php echo $this->Form->input('Estagiario.tc_solicitacao', array('type' => 'hidden', 'label' => ['text' => 'Data de solicitação do TC', 'class' => 'col-4'], 'dateFormat' => 'DMY', 'empty' => TRUE)); ?>
    <?php echo $this->Form->input('Estagiario.id_instituicao', array('label' => ['text' => 'Instituição', 'class' => 'col-4'], 'options' => $instituicoes, 'empty' => ['0' => 'Seleciona'])); ?>
    <?php echo $this->Form->input('Estagiario.id_supervisor', array('label' => ['text' => 'Supervisor', 'class' => 'col-4'], 'options' => $supervisores, 'empty' => ['0' => 'Seleciona'])); ?>
    <?php echo $this->Form->input('Estagiario.id_professor', array('label' => ['text' => 'Professor', 'class' => 'col-4'], 'options' => $professores, 'empty' => ['0' => 'Seleciona'])); ?>
    <?php echo $this->Form->input('Estagiario.id_area', array('label' => ['text' => 'Área temática', 'class' => 'col-4'], 'options' => $areas, 'empty' => ['0' => 'Seleciona'])); ?>
    <?php echo $this->Form->input('Estagiario.id_aluno', array('type' => 'hidden')); ?>
    <?php echo $this->Form->input('Estagiario.nota', array('type' => 'text', 'label' => ['text' => 'Nota: separar casas decimais com ponto', 'class' => 'col-4'])); ?>
    <?php echo $this->Form->input('Estagiario.ch', array('type' => 'text', 'label' => ['text' => 'Carga horária (Digitar números inteiros)', 'class' => 'col-4'])); ?>
    <?php echo $this->Form->input('Estagiario.observacoes', array('label' => ['text' => 'Observações', 'class' => 'col-4'])); ?>
    <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
    <div class='row justify-content-center'>
        <div class="col-auto">
            <?php echo $this->Form->input('Atualizar', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-primary position-static']); ?>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>

</div>