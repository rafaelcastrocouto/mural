<?php ?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Instituicaos', 'action' => 'seleciona_supervisor')); ?>";
        /* alert(base_url); */

        $("#InscricaoIdInstituicao").change(function () {
            var id_instituicao = $(this).val();
            $("#InscricaoIdSupervisor").load(base_url + "/" + id_instituicao);
            /* alert(id_instituicao); */
        })
    });

</script>

<?php
if ($turno == 'D') {
    $turno_text = 'Diurno';
} elseif ($turno == 'N') {
    $turno_text = 'Noturno';
} elseif ($turno == 'I') {
    $turno_text = 'Indefinido';
} else {
    $turno_text = 'Sem dados';
}
?>
<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <h1>Termo de Compromisso para cursar estágio no período <?= $periodo ?></h1>
    <table class='table table-hover table-striped table-responsive'>
        <tbody>
            <tr>
                <td>Registro</td>
                <td><?= $registro ?></td>
            </tr>
            <tr>
                <td>Estudante</td>
                <td><?= $aluno ?></td>
            </tr>
            <tr>
                <td>Nível de estágio</td>          
                <td><?= $nivel ?></td>
            </tr>
            <tr>
                <td>Período</td>
                <td><?= $periodo ?></td>
            </tr>
            <tr>
                <td>Turno</td>
                <td><?= $turno_text ?></td>
            </tr>

        </tbody>
    </table>

    <?php
    echo $this->Form->create('Inscricao', ['url' => 'termocadastra?registro=' . $registro]);

    echo $this->Form->input('id_aluno', array('type' => 'hidden', 'label' => 'Registro', 'value' => $registro));
    echo $this->Form->input('aluno_nome', array('type' => 'hidden', 'value' => $aluno));
    echo $this->Form->input('nivel', array('type' => 'hidden', 'value' => $nivel));
    echo $this->Form->input('periodo', array('type' => 'hidden', 'value' => $periodo));
    echo $this->Form->input('turno', array('type' => 'hidden', 'value' => $turno));
    echo $this->Form->input('id_professor', array('type' => 'hidden', 'label' => 'Professor', 'value' => $professor_atual));
    ?>
    <?php
    echo $this->Form->input('id_instituicao', array('type' => 'select', 'label' => ['text' => 'Instituição (É obrigatório selecionar a instituição)', 'class' => 'col-12'], 'options' => $instituicoes, 'empty' => ['0' => 'Selecione'] ,'value' => $instituicao_atual, 'class' => 'form-control'));
    echo $this->Form->input('id_supervisor', array('type' => 'select', 'label' => ['text' => 'Supervisor (Se não souber quem é o supervisor, deixar em branco)', 'class' => 'col-12'], 'options' => $supervisores, 'value' => $supervisor_atual, 'empty' => ['0' => 'Selecione'], 'class' => 'form-control'));
    ?>
    <div class='row justify-content-left'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>