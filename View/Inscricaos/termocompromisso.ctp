<?php
// pr($estagiario_id);
// die();
?>

<script type="text/javascript">

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Instituicaos', 'action' => 'seleciona_supervisor')); ?>";
        /* alert(base_url); */

        $("#EstagiarioIdInstituicao").change(function () {
            var id_instituicao = $(this).val();
            $("#EstagiarioIdSupervisor").load(base_url + "/" + id_instituicao);
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
//     echo $this->Form->create('Inscricao', ['url' => 'termocadastra?registro=' . $registro]);
    echo $this->Form->create('Estagiario');
    if (isset($estagiario_id)):
        echo $this->Form->input('id', array('type' => 'hidden', 'label' => 'Estagiario', 'value' => $estagiario_id));
    endif;
    if (isset($aluno_atual_id)):
        echo $this->Form->input('id_aluno', array('type' => 'hidden', 'label' => 'Aluno', 'value' => $aluno_atual_id));
    else:
        echo $this->Form->input('id_aluno', array('type' => 'hidden', 'label' => 'Aluno', 'value' => 0));
    endif;
    echo $this->Form->input('alunonovo_id', array('type' => 'hidden', 'label' => 'Estudante', 'value' => $alunonovo_atual_id));
    echo $this->Form->input('registro', array('type' => 'hidden', 'label' => 'Registro', 'value' => $registro));
    echo $this->Form->input('aluno_nome', array('type' => 'hidden', 'value' => $aluno));
    echo $this->Form->input('nivel', array('type' => 'hidden', 'value' => $nivel));
    echo $this->Form->input('periodo', array('type' => 'hidden', 'value' => $periodo));
    echo $this->Form->input('turno', array('type' => 'hidden', 'value' => $turno));
    echo $this->Form->input('id_professor', array('type' => 'hidden', 'label' => 'Professor', 'value' => $professor_atual));
    echo $this->Form->input('tc_solicitacao', array('type' => 'hidden', 'label' => 'Data', 'value' => date('Y-m-d')));
    echo $this->Form->input('tc', array('type' => 'hidden', 'label' => 'TC', 'value' => 1));
    ?>

    <?php
    echo $this->Form->input('ajuste2020', array('type' => 'select', 'label' => ['text' => 'Ajuste curricular 2020?', 'class' => 'col-12'], 'value' => $ajuste2020, 'options' => [0 => 'Não', 1 => 'Sim'], 'default' => '1', 'class' => 'form-control'));
    echo "<small id='EstagiarioAjuste2020' class='form-text text-muted'>O ajuste curricular do ano 2020 mudou o estágio de 4 níveis de 120 horas cada para 3 níveis de 135 cada.</small>";
    echo $this->Form->input('tipo_de_estagio', array('type' => 'select', 'label' => ['text' => 'Seleciona tipo de estágio', 'class' => 'col-12'], 'value' => $tipo_de_estagio, 'options' => [1 => 'Presencial', 2 => 'Remoto'], 'default' => '1', 'class' => 'form-control'));
    echo $this->Form->input('id_instituicao', array('type' => 'select', 'label' => ['text' => 'Instituição (É obrigatório selecionar a instituição)', 'class' => 'col-12'], 'options' => $instituicoes, 'empty' => ['0' => 'Selecione'], 'value' => $instituicao_atual, 'class' => 'form-control'));
    echo $this->Form->input('id_supervisor', array('type' => 'select', 'label' => ['text' => 'Supervisor (Se não souber quem é o supervisor, deixar em branco)', 'class' => 'col-12'], 'options' => $supervisores, 'value' => $supervisor_atual, 'empty' => ['0' => 'Selecione'], 'class' => 'form-control'));
    ?>
    <div class='row justify-content-left'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>