<?php // pr($professores);   ?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Professors', 'action' => 'pauta')); ?>";
        /* alert(base_url); */

        $("#ProfessorPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "/periodo:" + periodo;
        })

    })

</script>

<?php echo $this->element('submenu_professores'); ?>

<?php if ($this->Session->read('categoria') === 'administrador'): ?>
    <?php echo $this->Form->create('Professor', array('controller' => 'Professor', 'url' => 'pauta', 'class' => 'form-inline')); ?>
    <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Período ', 'style' => 'display: inline'), 'options' => $todosPeriodo, 'default' => $periodo, 'class' => 'form-control')); ?>
    <?php echo $this->Form->end(); ?>
<?php else: ?>
    <h1>Pauta: <?php echo $periodo; ?></h1>
<?php endif; ?>

<?php $total = NULL; ?>
<div class='row justify-content-center'>
    <div class='col-auto'>
        <table class='table table-hover table-striped table-responsive'>
            <caption style="caption-side: top">Pauta: <?php echo $this->Html->link($periodo, '/Estagiarios/index/periodo:' . $periodo); ?></caption>
            <thead class='thead-light'>
                <tr>
                    <th><?php echo 'Professor'; ?></th>
                    <th><?php echo 'Departamento'; ?></th>
                    <th><?php echo 'Turma'; ?></th>
                    <th><?php // echo 'Turno';   ?></th>
                    <th><?php echo 'Turma'; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($professores as $c_professores): ?>
                    <tr>
                        <td><?php echo $this->Html->link($c_professores['professor'], '/Estagiarios/index/id_professor:' . $c_professores['professor_id'] . '/periodo:' . $periodo); ?></td>
                        <td><?php echo $c_professores['departamento']; ?></td>
                        <td><?php
                            if ($c_professores['area']) :
                                echo $c_professores['area'];
                            endif;
                            ?></td>
                        <td><?php // echo $c_professores['periodo'];   ?></td>
                        <td><?php echo $c_professores['estagiariosperiodo']; ?></td>
                    </tr>
                    <?php $total += $c_professores['estagiariosperiodo']; ?>
                <?php endforeach; ?>
                <tr>
                    <td>Total estudantes</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $total; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>