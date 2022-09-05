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
// pr($direcao);
// die();
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Estagiarios', 'action' => 'lista')); ?>";
        /* alert(base_url); */

        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "?periodo=" + periodo;
        })
    });

</script>

<div class='row justify-content-left'>

    <?= $this->element('submenu_estagiarios') ?>

</div>

<?php ($periodo == '0' ? $periodo = "Todos" : $periodo = $periodo); ?>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <?php
        echo $this->Form->create('Estagiario', [
            'role' => 'form',
            'class' => 'form-inline',
            'inputDefaults' => [
                'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
                'div' => ['class' => 'form-group row text-center'],
                'label' => ['class' => 'col-1 col-form-label'],
                'between' => "<div class = 'col-2'>",
                'class' => ['form-control'],
                'after' => "</div>",
                'error' => false
            ]
                ]
        );
        echo $this->Form->input('periodo', ['label' => ['text' => 'Período', 'class' => 'col-1 col-form-label'], 'type' => 'select', 'options' => $periodos_total, 'selected' => $periodo, 'empty' => array('0' => 'Período')]);
        echo $this->Form->end();
        ?>
    </div>
</div>

<?php if ($estagiarios): ?>

    <div class='table-responsive'>
        <table class="table table-hover table-striped table-responsive">
            <thead class='thead-light'>
                <tr>
                    <?php if ($this->Session->read('id_categoria') != '2'): ?>
                        <th><?php echo $this->Paginator->sort('Estagiario.registro', 'Registro'); ?></th>
                    <?php endif; ?>
                    <th><?php echo $this->Paginator->sort('Alunonovo.nome', 'Nome'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.periodo', 'Periodo'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.nivel', 'Nível'); ?></th>
                    <th><?php echo $this->Paginator->sort('Alunonovo.ingresso', 'Ingresso'); ?></th>
                    <th><?php echo $this->Paginator->sort('Alunonovo.turno', 'Turno'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.ajuste2020', 'Ajuste 2020'); ?></th>
                    <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                        <th><?php echo $this->Paginator->sort('Estagiario.nota', 'Nota'); ?></th>
                        <th><?php echo $this->Paginator->sort('Estagiario.ch', 'CH'); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <?php foreach ($estagiarios as $estagiario): ?>
                <tr>
                    <?php if ($this->Session->read('id_categoria') != '2'): ?>
                        <td style='text-align:center'><?php echo $this->Html->link($estagiario['Estagiario']['registro'], "/estagiarios/view/" . $estagiario['Estagiario']['id']); ?></td>
                    <?php endif; ?>
                    <?php if ($this->Session->read('id_categoria') != '2'): ?>
                        <td style='text-align:left'><?php echo $this->Html->link($estagiario['Alunonovo']['nome'], ['controller' => 'Alunonovos', 'action' => 'view', $estagiario['Alunonovo']['id']]); ?></td>
                    <?php else: ?>
                        <td style='text-align:left'><?php echo $estagiario['Alunonovo']['nome']; ?></td>
                    <?php endif; ?>
                    <td style='text-align:center'><?php echo $estagiario['Estagiario']['periodo']; ?></td>
                    <?php if ($estagiario['Estagiario']['nivel'] == 9): ?>
                        <td style='text-align:center'><?php echo 'Não obrigatório'; ?></td>
                    <?php else: ?>
                        <td style='text-align:center'><?php echo $estagiario['Estagiario']['nivel']; ?></td>
                    <?php endif; ?>
                    <td style='text-align:left'><?php echo $estagiario['Alunonovo']['ingresso']; ?></td>
                    <td style='text-align:left'><?php echo $estagiario['Alunonovo']['turno']; ?></td>
                    <td style='text-align:left'><?php echo ($estagiario['Estagiario']['ajuste2020'] == 0) ? 'Não' : 'Sim'; ?></td>
                    <?php if ($this->Session->read('id_categoria') != '2'): ?>
                        <td style='text-align:center'><?php echo $estagiario['Estagiario']['nota']; ?></td>
                        <td style='text-align:center'><?php echo $estagiario['Estagiario']['ch']; ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php else: ?>
    <div class="alert alert-success" role="alert">
        Não há estudantes em atraso ou abandono!
    </div>
<?php endif; ?>