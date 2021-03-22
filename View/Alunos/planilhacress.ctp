<?php
// pr($cress);
// pr($periodos);
// pr($periodoatual);
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Alunos', 'action' => 'planilhacress')); ?>";
        /* alert(base_url); */

        $("#AlunoPeriodo").change(function () {
            var periodo = $(this).val();
            window.location = base_url + "/periodo:" + periodo;
        })
    });

</script>

<div class='table-responsive'>
    <?php echo $this->Form->create('Aluno', array('url' => 'index', 'class' => 'form-inline')); ?>
    <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => ['style' => 'display:inline'], 'options' => $periodos, 'selected' => $periodoatual, 'empty' => array($periodoatual => 'Período'), 'class' => 'form-control')); ?>
    <?php // echo $this->Form->end(); ?>
</div>

<table class='table table-hover table-striped table-responsive'>
    <caption style='caption-side: top;'>Escola de Serviço Social da UFRJ. Planilha de estagiários para o CRESS 7ª Região</caption>
    <thead class='thead-light'>
        <tr>
            <th>Estudante</th>
            <th>Instituição</th>
            <th>Endereço</th>
            <th>CEP</th>
            <th>Bairro</th>
            <th>Supervisor</th>
            <th>CRESS</th>
            <th>Professor</th>
        </tr>
    </thead>
    <?php foreach ($cress as $c_cress): ?>
        <?php // pr($c_cress); ?>
        <tr>
            <td><?php echo $this->Html->link($c_cress['Aluno']['nome'], '/alunos/view/' . $c_cress['Aluno']['id']); ?></td>
            <td><?php echo $this->Html->link($c_cress['Instituicao']['instituicao'], '/instituicaos/view/' . $c_cress['Instituicao']['id']); ?></td>
            <td><?php echo $c_cress['Instituicao']['endereco']; ?></td>
            <td><?php echo $c_cress['Instituicao']['cep']; ?></td>
            <td><?php echo $c_cress['Instituicao']['bairro']; ?></td>
            <td><?php echo $c_cress['Supervisor']['nome']; ?></td>
            <td><?php echo $c_cress['Supervisor']['cress']; ?></td>
            <td><?php echo $c_cress['Professor']['nome']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
