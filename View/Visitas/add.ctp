<?php
// pr($visitas); 
?>

<div class='table-responsive'>

    <?php echo $this->element('submenu_visitas'); ?>

    <script>

        $(document).ready(function () {

            var base_url = "<?= $this->Html->url(array('controller' => 'visitas', 'action' => 'add/instituicao:')); ?>";
            /* alert(base_url); */

            $("#VisitaEstagioId").change(function () {
                var instituicao_id = $(this).val();
                window.location = base_url + instituicao_id;
            })

        })
    </script>

    <h1>Informe de visita institucional</h1>

    <?php if (!empty($visitas)): ?>
        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th>Id</th>
                    <th>Instituição</th>
                    <th>Data</th>
                    <th>Motivo</th>
                    <th>Responsável</th>
                    <th>Avaliação</th>
                </tr>
            </thead>
            <?php foreach ($visitas as $c_visita): ?>
                <?php // pr($c_visita); ?>
                <tr>
                    <td><?php echo $c_visita['Visita']['id']; ?></td>
                    <td><?php echo $c_visita['Instituicao']['instituicao']; ?></td>
                    <td><?php echo $this->Html->link(date('d-m-Y', strtotime($c_visita['Visita']['data'])), '/visitas/view/' . $c_visita['Visita']['id']); ?></td>
                    <td><?php echo $c_visita['Visita']['motivo']; ?></td>
                    <td><?php echo $c_visita['Visita']['responsavel']; ?></td>
                    <td><?php echo $c_visita['Visita']['avaliacao']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php endif; ?>

<?php
echo $this->Form->create('Visita', [
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

if (isset($instituicao_id)) {
    echo $this->Form->input('estagio_id', array('label' => ['text' => 'Instituição', 'class' => 'col-4'], 'options' => $instituicoes, 'default' => $instituicao_id));
} else {
    echo $this->Form->input('estagio_id', array('label' => ['text' => 'Instituição', 'class' => 'col-4'], 'options' => $instituicoes));
}
echo $this->Form->input('data', array('dateFormat' => 'DMY', 'monthNames' => $meses, 'between' => "<div class = 'form-inline col-8'>"));
echo $this->Form->input('motivo', ['class' => 'form-control']);
echo $this->Form->input('responsavel', ['class' => 'form-control']);
echo $this->Form->input('descricao', ['class' => 'form-control']);
echo $this->Form->input('avaliacao', ['class' => 'form-control']);
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
