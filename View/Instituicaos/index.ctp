<?php
// pr($instituicoes);
?>

<script>

    var base_url = "<?= $this->Html->url(["controller" => "Instituicaos", "action" => "index/"]); ?>";
    /* alert(base_url); */

    $(document).ready(function () {

        $("#InstituicaoPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo +  " " + limite); */
            window.location = base_url + "/periodo:" + periodo;
        })

    })

</script>

<div class="table-responsive">

    <?php echo $this->element('submenu_instituicoes'); ?>

    <?php if ($this->Session->read('id_categoria') == '1'): ?>

        <?php echo $this->Form->create('Instituicao', ['controller' => 'Instituicao', 'url' => 'index', 'class' => 'form-inline']); ?>
        <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => array('text' => 'Período ', 'style' => 'display: inline'), 'options' => $todosPeriodos, 'default' => $periodo, 'empty' => 'Selecione', 'class' => 'form-control')); ?>
        <?php echo $this->Form->end(); ?>

    <?php endif; ?>

    <div class='pagination justify-content-center'>
        <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
        <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
        <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
        <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
    </div>

    <div class="pagination justify-content-center">
        <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
    </div>

    <table class="table table-hover table-striped table-responsive">
        <thead class='thead-light'>
            <tr>
                <th>
                    <?php echo $this->Paginator->sort('Instituicao.id', 'Id'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Instituicao.instituicao', 'Instituição'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Instituicao.expira', 'Expira'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Instituicao.virtualMaxPeriodo', 'Último estágio'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Instituicao.virtualEstudantes', 'Estudantes'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Instituicao.virtualSupervisores', 'Supervisores'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Areainstituicao.area', 'Área'); ?>
                </th>
                <th>
                    <?php echo $this->Paginator->sort('Instituicao.natureza', 'Natureza'); ?>
                </th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($instituicoes as $c_instituicao): ?>
                <tr>
                    <td><?php echo $this->Html->link($c_instituicao['Instituicao']['id'], '/Instituicaos/view/' . $c_instituicao['Instituicao']['id']); ?></td>
                    <td><?php echo $this->Html->link($c_instituicao['Instituicao']['instituicao'], '/Instituicaos/view/' . $c_instituicao['Instituicao']['id']); ?></td>
                    <td><?php
                        if ($c_instituicao['Instituicao']['expira']):
                            echo date('d-m-Y', strtotime($c_instituicao['Instituicao']['expira']));
                        endif;
                        ?></td>
                    <td><?php echo $c_instituicao['Instituicao']['virtualMaxPeriodo']; ?></td>
                    <td><?php echo $c_instituicao['Instituicao']['virtualEstudantes']; ?></td>
                    <td><?php echo $c_instituicao['Instituicao']['virtualSupervisores']; ?></td>
                    <td><?php echo $c_instituicao['Areainstituicao']['area']; ?></td>
                    <td><?php echo $c_instituicao['Instituicao']['natureza']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    echo $this->Paginator->counter(array(
        'format' => 'Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
    ));
    ?>
</div>