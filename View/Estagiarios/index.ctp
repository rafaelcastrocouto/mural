<?php
// pr($periodoatual);
// pr($nivel);
// pr($periodos_todos);
// pr($id_supervisor);
// pr($supervisores);
// pr($estagiarios);
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Estagiarios', 'action' => 'index')); ?>";
        /* alert(base_url); */

        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "/index/periodo:" + periodo;
        })

        $("#EstagiarioComplementoPeriodoEspecial").change(function () {
            var complemento_periodo_especial = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "/index/complemento_periodo_especial:" + complemento_periodo_especial;
        })

        $("#EstagiarioIdArea").change(function () {
            var id_area = $(this).val();
            /* alert(id_area); */
            window.location = base_url + "/index/id_area:" + id_area;
        })

        $("#EstagiarioIdProfessor").change(function () {
            var id_professor = $(this).val();
            /* alert(id_professor); */
            window.location = base_url + "/index/id_professor:" + id_professor;
        })

        $("#EstagiarioIdInstituicao").change(function () {
            var id_instituicao = $(this).val();
            /* alert(id_instituicao); */
            window.location = base_url + "/index/id_instituicao:" + id_instituicao;
        })

        $("#EstagiarioIdSupervisor").change(function () {
            var id_supervisor = $(this).val();
            /* alert(id_supervisor); */
            window.location = base_url + "/index/id_supervisor:" + id_supervisor;
        })

        $("#EstagiarioNivel").change(function () {
            var nivel = $(this).val();
            /* alert(nivel); */
            window.location = base_url + "/index/nivel:" + nivel;
        })

        $("#EstagiarioTurno").change(function () {
            var turno = $(this).val();
            /* alert(turno); */
            window.location = base_url + "/index/turno:" + turno;
        });

    });

</script>

<div class='table-responsive'>

    <?= $this->element('submenu_estagiarios') ?>

    <table 'class="table table-hover table-striped table-responsive">
        <tr>
            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos_todos, 'selected' => $periodo, 'empty' => array('0' => 'Período'), 'style' => 'width: 5em', 'class' => 'form-control form-control-sm')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>

            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('complemento_periodo_especial', array('type' => 'select', 'options' => $complemento_periodo_especial_total, 'selected' => $complemento_periodo_especial, 'empty' => array('0' => 'Complemento'), 'style' => 'width: 5em', 'class' => 'form-control form-control-sm')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>

            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('nivel', array('type' => 'select', 'options' => array('1' => 'OTP 1', '2' => 'OTP 2', '3' => 'OTP 3', '4' => 'OTP 4', '9' => 'Não obrigatório'), 'selected' => $nivel, 'default' => 0, 'empty' => array('0' => 'OTP'), 'style' => 'width: 5em', 'class' => 'form-control form-control-sm')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>

            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('turno', array('type' => 'select', 'options' => array('D' => 'Diurno', 'N' => 'Noturno'), 'selected' => $turno, 'empty' => array('0' => 'Turno'), 'style' => '5em', 'class' => 'form-control form-control-sm')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>

            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_area', array('type' => 'select', 'options' => $areas, 'selected' => $id_area, 'empty' => array('0' => 'Áreas'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>

            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_professor', array('type' => 'select', 'options' => $professores, 'selected' => $id_professor, 'default' => 0, 'empty' => array('0' => 'Professoras(es)'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>

            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_supervisor', array('type' => 'select', 'options' => $supervisores, 'selected' => $id_supervisor, 'default' => 0, 'empty' => array('0' => 'Supervisoras(es)'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>

            <td>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_instituicao', array('type' => 'select', 'options' => $instituicoes, 'selected' => $id_instituicao, 'default' => 0, 'empty' => array('0' => 'Instituições'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
                <?php // echo $this->Form->end(); ?>
            </td>
        </tr>
    </table>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>

        <?php ($periodo == 0 ? $periodo = "Todos" : $periodo = $periodo); ?>
        <h5>Estagiarios período: <?php echo $periodo; ?></h5>

        <div class='pagination justify-content-center'>
            <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
            <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
        </div>

        <div class="pagination justify-content-center">
            <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
        </div>
    </div>
</div>

<div class='table-responsive'>
    <table class="table table-hover table-striped table-responsive">
        <thead class='thead-light'>
            <tr>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <th><?php echo $this->Paginator->sort('Estagiario.registro', 'Registro'); ?></th>
                <?php endif; ?>
                <th><?php echo $this->Paginator->sort('Aluno.nome', 'Nome'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.periodo', 'Periodo'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.complemento_id', 'Especial'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.nivel', 'Nível'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.turno', 'Turno'); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.tc', 'TC'); ?></th>
                <th><?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?></th>
                <th><?php echo $this->Paginator->sort('Supervisor.nome', 'Supervisor'); ?></th>
                <th><?php echo $this->Paginator->sort('Professor.nome', 'Professor'); ?></th>
                <th><?php echo $this->Paginator->sort('Area.area', 'Área'); ?></th>
                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <th><?php echo $this->Paginator->sort('Estagiario.nota', 'Nota'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.ch', 'CH'); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <?php foreach ($estagiarios as $aluno): ?>
            <tr>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <td style='text-align:center'><?php echo $this->Html->link($aluno['Estagiario']['registro'], "/alunos/view/" . $aluno['Aluno']['id']); ?></td>
                <?php endif; ?>
                <td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>
                <td style='text-align:center'><?php echo $aluno['Estagiario']['periodo']; ?></td>
                <td style='text-align:center'><?php echo $aluno['Complemento']['periodo_especial']; ?></td>
                <?php if ($aluno['Estagiario']['nivel'] == 9): ?>
                    <td style='text-align:center'><?php echo 'Não obrigatório'; ?></td>
                <?php else: ?>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['nivel']; ?></td>
                <?php endif; ?>
                <td style='text-align:center'><?php echo $aluno['Estagiario']['turno']; ?></td>
                <td style='text-align:center'><?php echo $aluno['Estagiario']['tc']; ?></td>
                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Instituicao']['instituicao'], "/instituicaos/view/" . $aluno['Estagiario']['id_instituicao']); ?></td>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Supervisor']['nome'], "/supervisors/view/" . $aluno['Estagiario']['id_supervisor']); ?></td>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Professor']['nome'], "/professors/view/" . $aluno['Estagiario']['id_professor']); ?></td>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Area']['area'], "/Areas/view/" . $aluno['Area']['id']); ?></td>
                <?php else: ?>
                    <td style='text-align:left'><?php echo $aluno['Instituicao']['instituicao']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Supervisor']['nome']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Professor']['nome']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Area']['area']; ?></td>
                <?php endif; ?>
                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['nota']; ?></td>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['ch']; ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    echo $this->Paginator->counter(array(
        'format' => "Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%"
    ));
    ?>
</div>