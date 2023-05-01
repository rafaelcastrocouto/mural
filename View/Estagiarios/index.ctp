<?php
// echo " Período atual: ";
// pr($periodoatual);
// echo " período: ";
// pr($periodo);
// pr($nivel);
// pr($periodos_total);
// pr($id_supervisor);
// pr($supervisores);
// pr($estagiarios);
// die();
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

    <table class='table table-hover table-striped table-responsive'>
        <tr>
            <td class='p-0'>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos_total, 'selected' => $periodo, 'empty' => array('0' => 'Período'), 'style' => 'width: 5em', 'class' => 'form-control form-control-sm')); ?>
                <?php echo $this->Form->end(); ?>
            </td>

            <td class='p-0'>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('complemento_periodo_especial', array('type' => 'select', 'options' => $complemento_periodo_especial_total, 'selected' => $complemento_periodo_especial, 'empty' => array('0' => 'Modalidade'), 'style' => 'width: 5em', 'class' => 'form-control form-control-sm')); ?>
                <?php echo $this->Form->end(); ?>
            </td>

            <td class='p-0'>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('nivel', array('type' => 'select', 'options' => array('1' => 'OTP 1', '2' => 'OTP 2', '3' => 'OTP 3', '4' => 'OTP 4', '9' => 'Não obrigatório'), 'selected' => $nivel, 'default' => 0, 'empty' => array('0' => 'OTP'), 'style' => 'width: 5em', 'class' => 'form-control form-control-sm')); ?>
                <?php echo $this->Form->end(); ?>
            </td>

            <td class='p-0'>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('turno', array('type' => 'select', 'options' => array('D' => 'Diurno', 'N' => 'Noturno'), 'selected' => $turno, 'empty' => array('0' => 'Turno'), 'style' => '5em', 'class' => 'form-control form-control-sm')); ?>
                <?php echo $this->Form->end(); ?>
            </td>

            <td class='p-0'>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_area', array('type' => 'select', 'options' => $areas, 'selected' => $id_area, 'empty' => array('0' => 'Áreas'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
                <?php echo $this->Form->end(); ?>
            </td>

            <td class='p-0'>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_professor', array('type' => 'select', 'options' => $professores, 'selected' => $id_professor, 'default' => 0, 'empty' => array('0' => 'Professoras(es)'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
                <?php echo $this->Form->end(); ?>
            </td>

            <td class='p-0'>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_supervisor', array('type' => 'select', 'options' => $supervisores, 'selected' => $id_supervisor, 'default' => 0, 'empty' => array('0' => 'Supervisoras(es)'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
                <?php echo $this->Form->end(); ?>
            </td>

            <td class='p-0'>
                <?php echo $this->Form->create('Estagiario', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
                <?php echo $this->Form->input('id_instituicao', array('type' => 'select', 'options' => $instituicoes, 'selected' => $id_instituicao, 'default' => 0, 'empty' => array('0' => 'Instituições'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
                <?php echo $this->Form->end(); ?>
            </td>
        </tr>
    </table>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>

        <?php ($periodo == '0' ? $periodo = "Todos" : $periodo = $periodo); ?>
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
<?php
$transporte = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bus-front" viewBox="0 0 16 16">
  <path d="M5 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-6-1a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm1-6c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9c1.876 0 3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44.303 44.303 0 0 0 8 4Zm0-1c-1.837 0-3.353.107-4.448.22a.5.5 0 1 1-.104-.994A44.304 44.304 0 0 1 8 2c1.876 0 3.426.109 4.552.226a.5.5 0 1 1-.104.994A43.306 43.306 0 0 0 8 3Z"/>
  <path d="M15 8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1V2.64c0-1.188-.845-2.232-2.064-2.372A43.61 43.61 0 0 0 8 0C5.9 0 4.208.136 3.064.268 1.845.408 1 1.452 1 2.64V4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v3.5c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2V8ZM8 1c2.056 0 3.71.134 4.822.261.676.078 1.178.66 1.178 1.379v8.86a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 11.5V2.64c0-.72.502-1.301 1.178-1.379A42.611 42.611 0 0 1 8 1Z"/>
</svg>';

$alimentacao = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cup-straw" viewBox="0 0 16 16">
<path d="M13.902.334a.5.5 0 0 1-.28.65l-2.254.902-.4 1.927c.376.095.715.215.972.367.228.135.56.396.56.82 0 .046-.004.09-.011.132l-.962 9.068a1.28 1.28 0 0 1-.524.93c-.488.34-1.494.87-3.01.87-1.516 0-2.522-.53-3.01-.87a1.28 1.28 0 0 1-.524-.93L3.51 5.132A.78.78 0 0 1 3.5 5c0-.424.332-.685.56-.82.262-.154.607-.276.99-.372C5.824 3.614 6.867 3.5 8 3.5c.712 0 1.389.045 1.985.127l.464-2.215a.5.5 0 0 1 .303-.356l2.5-1a.5.5 0 0 1 .65.278zM9.768 4.607A13.991 13.991 0 0 0 8 4.5c-1.076 0-2.033.11-2.707.278A3.284 3.284 0 0 0 4.645 5c.146.073.362.15.648.222C5.967 5.39 6.924 5.5 8 5.5c.571 0 1.109-.03 1.588-.085l.18-.808zm.292 1.756C9.445 6.45 8.742 6.5 8 6.5c-1.133 0-2.176-.114-2.95-.308a5.514 5.514 0 0 1-.435-.127l.838 8.03c.013.121.06.186.102.215.357.249 1.168.69 2.438.69 1.27 0 2.081-.441 2.438-.69.042-.029.09-.094.102-.215l.852-8.03a5.517 5.517 0 0 1-.435.127 8.88 8.88 0 0 1-.89.17zM4.467 4.884s.003.002.005.006l-.005-.006zm7.066 0-.005.006c.002-.004.005-.006.005-.006zM11.354 5a3.174 3.174 0 0 0-.604-.21l-.099.445.055-.013c.286-.072.502-.149.648-.222z"/>
</svg>';

$bolsa = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
<path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
</svg>';
?>

<div class='table-responsive'>
    <table class="table table-hover table-striped table-responsive">
        <thead class='thead-light'>
            <tr style="height: 1px;">
                <?php if ($this->Session->read('id_categoria') != '2'): ?>
                    <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Estagiario.registro', 'Registro'); ?></th>
                <?php endif; ?>
                <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Aluno.nome', 'Nome'); ?></th>
                <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Alunonovo.ingresso', 'Ingresso'); ?></th>
                <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Alunonovo.turno', 'Turno'); ?></th>
                <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Estagiario.periodo', 'Periodo'); ?></th>
                <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Estagiario.nivel', 'Nível'); ?></th>
                <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?></th>
                <th colspan="3" style="vertical-align: baseline;"><?php echo $this->Paginator->sort('Estagiario.benebolsa', 'Benefícios'); ?></th>
                <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Supervisor.nome', 'Supervisor'); ?></th>
                <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Professor.nome', 'Professor'); ?></th>
                <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                    <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Estagiario.nota', 'Nota'); ?></th>
                    <th rowspan="2" style="vertical-align: middle;"><?php echo $this->Paginator->sort('Estagiario.ch', 'CH'); ?></th>
                <?php endif; ?>
            </tr>
            <tr style="height: 50px; vertical-align: top">
                <th><?php echo $this->Paginator->sort('Estagiario.benetransporte', $transporte, ['escape' => false]) ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.benealimentacao', $alimentacao, ['escape' => false]); ?></th>
                <th><?php echo $this->Paginator->sort('Estagiario.benebolsa', $bolsa, ['escape' => false]); ?></th>
            </tr>
        </thead>
        <?php foreach ($estagiarios as $aluno): ?>
            <?php # pr($aluno) ?>
            <tr>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <td style='text-align:center'><?php echo $this->Html->link($aluno['Estagiario']['registro'], "/estagiarios/view/" . $aluno['Estagiario']['id']); ?></td>
                <?php elseif ($this->Session->read('id_categoria') == '4'): ?>
                    <td style='text-align:center'><?php echo $this->Html->link($aluno['Estagiario']['registro'], "/estagiarios/view/" . $aluno['Estagiario']['id']); ?></td>
                <?php elseif ($this->Session->read('id_categoria') == '3'): ?>
                    <td style='text-align:center'><?php echo $this->Html->link($aluno['Estagiario']['registro'], "/estagiarios/view/" . $aluno['Estagiario']['id']); ?></td>
                <?php endif; ?>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Alunonovo']['nome'], ['controller' => 'Alunonovos', 'action' => 'view', $aluno['Alunonovo']['id']]); ?></td>
                <?php else: ?>
                    <td style='text-align:left'><?php echo $aluno['Alunonovo']['nome']; ?></td>
                <?php endif; ?>
                <td style='text-align:left'><?php echo $aluno['Alunonovo']['ingresso']; ?></td>
                <td style='text-align:left'><?php echo $aluno['Alunonovo']['turno']; ?></td>
                <td style='text-align:left'><?php echo $aluno['Estagiario']['periodo']; ?></td>

                <?php if ($aluno['Estagiario']['nivel'] == 9): ?>
                    <td style='text-align:center'><?php echo 'Não obrigatório'; ?></td>
                <?php else: ?>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['nivel']; ?></td>
                <?php endif; ?>

                <?php if ($this->Session->read('id_categoria') != '2'): ?>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Instituicao']['instituicao'], "/instituicaos/view/" . $aluno['Estagiario']['id_instituicao']); ?></td>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['benetransporte'] == '1' ? 'Sim' : ''; ?></td>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['benealimentacao'] == '1' ? 'Sim' : ''; ?></td>
                    <td style='text-align:center'><?php echo $aluno['Estagiario']['benebolsa']; ?></td>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Supervisor']['nome'], "/supervisors/view/" . $aluno['Estagiario']['id_supervisor']); ?></td>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Professor']['nome'], "/professors/view/" . $aluno['Estagiario']['id_professor']); ?></td>
                <?php else: ?>
                    <td style='text-align:left'><?php echo $aluno['Instituicao']['instituicao']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Supervisor']['nome']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Professor']['nome']; ?></td>
                    <td style='text-align:left'><?php echo $aluno['Area']['area']; ?></td>
                <?php endif; ?>
                <?php if ($this->Session->read('id_categoria') != '2'): ?>
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