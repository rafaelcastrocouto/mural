<?php// pr($t_seguro);     ?>
<?php // pr($periodos);     ?>
<?php // pr($periodoselecionado);     ?>
<?php // die();     ?>

<script>

    var base_url = "<?= $this->Html->url(array('controller' => 'Alunos', 'action' => 'planilhacress')); ?>";
    /* alert(base_url); */

    $(document).ready(function () {

        $("#AlunoPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "/periodo:" + periodo;
        })
    });

</script>

<div class='table-responsive'>
    
<?php echo $this->Form->create('Aluno', array('url' => 'index', 'class' => 'form-inline')); ?>
<?php echo $this->Form->input('periodo', ['type' => 'select', 'label' => ['style' => 'display:inline;'] ,'options' => $periodos, 'selected' => $periodoselecionado, 'empty' => array($periodoselecionado => 'Período'), 'class' => 'form-control']); ?>
<?php // echo $this->Form->end(); ?>

    <table class='table table-hover table-striped table-responsive'>
        <thead class='thead-light'>
        <caption style='caption-side: top'>Planilha para seguro de vida dos estudantes estagiários</caption>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Nascimento</th>
            <th>Sexo</th>
            <th>DRE</th>
            <th>Curso</th>
            <th>Nível</th>
            <th>Período</th>
            <th>Início</th>
            <th>Final</th>
            <th>Instituição</th>
        </tr>
        </thead>
<?php foreach ($t_seguro as $cada_aluno): ?>
            <?php // pr($cada_aluno);  ?>
            <?php // die(); ?>
            <tr>
                <td>
    <?php echo $this->Html->link($cada_aluno['nome'], '/alunos/view/' . $cada_aluno['id']); ?>
                </td>
                <td>
    <?php echo $cada_aluno['cpf']; ?>
                </td>
                <td>
    <?php if (empty($cada_aluno['nascimento'])): ?>
                        <?php echo "s/d"; ?>
                    <?php else: ?>
                        <?php echo date('d-m-Y', strtotime($cada_aluno['nascimento'])); ?>
                    <?php endif; ?>
                </td>
                <td>
    <?php echo $cada_aluno['sexo']; ?>
                </td>
                <td>
    <?php echo $cada_aluno['registro']; ?>
                </td>
                <td>
    <?php echo $cada_aluno['curso']; ?>
                </td>
                <td>
    <?php echo $cada_aluno['nivel']; ?>
                </td>
                <td>
    <?php echo $cada_aluno['periodo']; ?>
                </td>
                <td>
    <?php echo $cada_aluno['inicio']; ?>
                </td>
                <td>
    <?php echo $cada_aluno['final']; ?>
                </td>
                <td>
    <?php echo $cada_aluno['instituicao']; ?>
                </td>
            </tr>
<?php endforeach; ?>
    </table>
</div>