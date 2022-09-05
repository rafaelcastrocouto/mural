<?php
// pr($supervisores);
?>

<script>

    $(document).ready(function () {

        $("#SupervisorPeriodo").change(function () {
            var periodo = $(this).val();
            var link = "<?= $this->Html->url(["controller" => "Supervisors", "action" => "index/periodo:"]); ?>";
            var link = link + periodo;
            /* alert(link); */
            $(location).attr('href', link);
            /* window.location=url; */
        })
    })

</script>

<div class='row justify-content-left'>
    <div class='col-auto'>
        <?= $this->element('submenu_supervisores') ?>
    </div>
</div>
<div class='row justify-content-left'>
    <div class='col-auto'>
        <?php if ($this->Session->read('id_categoria') == '1'): ?>
            <?php echo $this->Form->create('Supervisor', ['class' => 'form-inline']); ?>
            <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Período ', 'style' => 'display: inline'), 'options' => $todosPeriodos, 'default' => $periodo, 'empty' => 'Selecione', 'class' => 'form-control')); ?>
            <?php echo $this->Form->end(); ?>
        <?php endif; ?>
    </div>
</div>

<div class='pagination justify-content-center'>
    <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
    <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
</div>

<div class="pagination justify-content-center">
    <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
</div>

<table class='table table-hover table-striped table-responsive'>

    <thead class='thead-light'>
        <tr>
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <th>X</th>
                <th width='10%'><?php echo $this->Paginator->sort('Supervisor.cress', 'CRESS'); ?></th>
            <?php endif; ?>
            <th width='50%'><?php echo $this->Paginator->sort('Supervisor.nome', 'Nome'); ?></th>
            <th width='10%'><?php echo $this->Paginator->sort('Supervisor.virtualestagiarios', 'Estagiários'); ?></th>
            <th width='10%'><?php echo $this->Paginator->sort('Supervisor.virtualestudantes', 'Estudantes'); ?></th>
            <th width='10%'><?php echo $this->Paginator->sort('Supervisor.virtualperiodos', 'Períodos'); ?></th>
            <th width='10%'><?php echo $this->Paginator->sort('Supervisor.virtualmaxperiodo', 'Último período'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($supervisores as $c_supervisor): ?>
            <tr>
                <?php if (empty($c_supervisor['Supervisor']['id'])): ?>
                    <?php $c_supervisor['Supervisor']['id'] = 0; ?>
                <?php endif; ?>

                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <td>
                        <?php echo $this->Html->link('X', '/Supervisors/delete/' . $c_supervisor['Supervisor']['id'], NULL, 'Confirma?'); ?>
                    </td>
                    <td>
                        <?php echo $c_supervisor['Supervisor']['cress']; ?>
                    </td>
                <?php endif; ?>

                <td>
                    <?php
                    if ($c_supervisor['Supervisor']['nome']):
                        if ($this->Session->read('id_categoria') == '1'):
                            echo $this->Html->link($c_supervisor['Supervisor']['nome'], '/Supervisors/view/' . $c_supervisor['Supervisor']['id']);
                        else:
                            echo $c_supervisor['Supervisor']['nome'];
                        endif;
                    else:
                        echo "Sem dados";
                    endif;
                    ?>
                </td>

                <td>
                    <?php
                    if ($c_supervisor['Supervisor']['nome']):
                        echo $this->Html->link($c_supervisor['Supervisor']['virtualestagiarios'], '/Estagiarios/index/periodo:' . '0' . '/id_supervisor:' . $c_supervisor['Supervisor']['id']);
                    else:
                        echo $this->Html->link($c_supervisor['Supervisor']['virtualestagiarios'], '/Estagiarios/index/periodo:' . $c_supervisor['Supervisor']['virtualmaxperiodo'] . '/sort:' . 'Supervisor.nome/direction:asc');
                    endif;
                    ?>
                </td>

                <td>
                    <?php
                    if ($c_supervisor['Supervisor']['nome']):
                        echo $this->Html->link($c_supervisor['Supervisor']['virtualestudantes'], '/Estagiarios/index/periodo:' . '0' . '/id_supervisor:' . $c_supervisor['Supervisor']['id']);
                    else:
                        echo $this->Html->link($c_supervisor['Supervisor']['virtualestudantes'], '/Estagiarios/index/periodo:' . $c_supervisor['Supervisor']['virtualmaxperiodo'] . '/sort:' . 'Supervisor.nome/direction:asc');
                    endif;
                    ?>
                </td>

                <td>
                    <?php
                    if ($c_supervisor['Supervisor']['nome']):
                        echo $this->Html->link($c_supervisor['Supervisor']['virtualperiodos'], '/Estagiarios/index/periodo:' . '0' . '/id_supervisor:' . $c_supervisor['Supervisor']['id']);
                    else:
                        echo $this->Html->link($c_supervisor['Supervisor']['virtualperiodos'], '/Estagiarios/index/periodo:' . $c_supervisor['Supervisor']['virtualmaxperiodo'] . '/sort:' . 'Supervisor.nome/direction:asc');
                    endif;
                    ?>
                </td>

                <td>
                    <?php echo $c_supervisor['Supervisor']['virtualmaxperiodo']; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<div class='justify-content-center'>
    <?php
    echo $this->Paginator->counter(array(
        'format' => 'Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
    ));
    ?>
</div>