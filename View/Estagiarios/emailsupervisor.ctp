<?php
// echo " Período atual: ";
// pr($email);
// echo " período: ";
// pr($periodo);
// pr($periodos);
// die();
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Estagiarios', 'action' => 'emailsupervisor')); ?>";
        /* alert(base_url); */

        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "/periodo:" + periodo;
        })

    });

</script>

<?= $this->element('submenu_estagiarios') ?>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <?php echo $this->Form->create('Estagiario', [
            'url' => 'email',
            'class' => 'form-horizontal was-validated',
            'role' => 'form',
            'inputDefaults' => [
                'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
                'div' => ['class' => 'form-group row'],
                'label' => ['class' => 'col-5'],
                'between' => "<div class = 'col-7'>",
                'class' => ['form-control'],
                'after' => '</div>',
                'error' => '<div class="invalid-feedback">Digite um valor correto neste campo.</div>'
            ]
        ]);

        echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos, 'selected' => $periodo, 'empty' => array('0' => 'Período'), 'class' => 'form-control form-control-sm'));
        echo $this->Form->end();
        ?>
    </div>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>

        <?php ($periodo == '0' ? $periodo = "Todos" : $periodo = $periodo); ?>
        <h5>E-mails dos supervisores período:
            <?php echo $periodo; ?>
        </h5>

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

<div class='row justify-content-center'>
    <div class='col-auto'>
        <table class="table table-hover table-striped table-responsive">
            <thead class='thead-light'>
                <tr style="height: 1px;">
                    <?php if ($this->Session->read('id_categoria') != '2'): ?>
                        <th rowspan="2" style="vertical-align: middle;">
                            <?php echo $this->Paginator->sort('Supervisor.nome', 'Nome'); ?>
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            <?php $supervisores = null ?>
            <?php foreach ($email as $supervisor): ?>
                <?php # pr($supervisor) ?>

                <tr>
                    <?php if ($supervisor['Supervisor']['email']): ?>
                        <td class='text-left'>
                            <?php echo $this->Html->link('"' . $supervisor['Supervisor']['nome'] . '"' . ' <' . $supervisor['Supervisor']['email'] . '>' . ', ', ['controller' => 'alunonovos', 'action' => 'view', $supervisor['Alunonovo']['id']]); ?>
                        </td>
                    <?php else: ?>
                        <?php if (empty($supervisor['Supervisor']['nome'])): ?>
                            <?php if (empty($supervisor['Alunonovo']['nome'])): ?>
                                <td class='bg-danger text-dark text-left'>
                                    <?php echo "Error!: registro sem nome do estagiário nem supervisor" ?>
                                </td>
                            <?php else: ?>                            
                                <td class='bg-info text-dark text-left'>
                                    <?php echo $this->Html->link("Estagiária(o): " . $supervisor['Alunonovo']['nome'] . " - Sem supervisor", ['controller' => 'alunonovos', 'action' => 'view', $supervisor['Alunonovo']['id']]); ?>
                                </td>
                            <?php endif; ?>
                        <?php else: ?>
                            <td class='bg-warning text-dark text-left'>
                                <?php echo $this->Html->link('"' . $supervisor['Supervisor']['nome'] . '"' . ' <' . 'estagio@ess.ufrj.br' . '>' . ', ', ['controller' => 'alunonovos', 'action' => 'view', $supervisor['Alunonovo']['id']]); ?>
                            </td>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
                
                <?php $supervisores .= '"' . $supervisor['Supervisor']['nome'] . '" ' . htmlspecialchars('<') . $supervisor['Supervisor']['email'] . htmlspecialchars('>') . ', ' . '<br>'; ?>
            <?php endforeach; ?>
        </table>
        <?php // print_r($estagiarios) ?>
        <?php
        echo $this->Paginator->counter(
            array(
                'format' => "Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%"
            )
        );
        ?>
    </div>
</div>