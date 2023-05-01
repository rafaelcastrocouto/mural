<?php
// pr('alunonovoturno ' . $alunonovoturno);
// pr('Super ' . $supervisor_atual);
// pr($ingresso);
// die();
?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>
    $(document).ready(function () {

        $("#EstagiarioIngresso").mask("9999-9");

    });

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

<div class='justify-content-center'>
<?php
if ($inserir == 0) {
    echo "<p class='h2 text-primary'>Inserir</p>";
} elseif ($inserir == 1) {
    echo "<p class='h2 text-secondary'>Atualizar</p>";
}
?>
</div>

<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <h1>Termo de Compromisso período
        <?= $periodo ?>
    </h1>

    <table class='table table-hover table-striped table-responsive'>
        <tbody>
            <tr>
                <td>Registro:</td>
                <td>
                    <?= $registro ?>
                </td>
                <td>Estudante:</td>
                <td>
                    <?= $aluno ?>
                </td>
            </tr>
            <tr>
                <td>Nível de estágio</td>
                <td>
                    <?= $estagio_nivel = ($nivel == 9) ? "Não obrigatório " : $nivel ?>
                </td>
                <td>Período</td>
                <td>
                    <?= $periodo ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
echo $this->Form->create('Estagiario', [
    'url' => 'termocadastra?registro=' . $registro,
    'class' => 'form-horizontal',
    'role' => 'form',
    'inputDefaults' => [
        'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
        'div' => ['class' => 'form-group row'],
        'label' => ['class' => 'col-3'],
        'between' => "<div class = 'col-9'>",
        'class' => ['form-control'],
        'after' => "</div>",
        'error' => ['attributes' => ['wrap' => 'span', 'class' => 'help-inline']]
    ]
]);

echo $this->Form->input('id', array('type' => 'hidden', 'value' => $estagiario_id));
echo $this->Form->input('inserir', array('type' => 'hidden', 'value' => $inserir));
echo $this->Form->input('id_aluno', array('type' => 'hidden', 'value' => $id_aluno));
echo $this->Form->input('registro', array('type' => 'hidden', 'value' => $registro));
echo $this->Form->input('turno', array('type' => 'hidden', 'value' => $turno));
echo $this->Form->input('nivel', array('type' => 'hidden', 'value' => $nivel));
echo $this->Form->input('tc', array('type' => 'hidden', 'value' => 1));
echo $this->Form->input('tc_solicitacao', array('type' => 'hidden', 'value' => date('Y-m-d')));
echo $this->Form->input('id_professor', array('type' => 'hidden', 'label' => 'Professor', 'value' => $professor_atual));
echo $this->Form->input('periodo', array('type' => 'hidden', 'value' => $periodo));
// echo $this->Form->input('id_area', array('type' => 'hidden', 'value' => $id_area));
echo $this->Form->input('complemento_id', array('type' => 'hidden', 'value' => $complemento_id));
echo $this->Form->input('alunonovo_id', array('type' => 'hidden', 'value' => $alunonovo_id));

if (strlen($ingresso) == 6) {
    echo $this->Form->input('ingresso', ['type' => 'hidden', 'label' => ['text' => 'Ano e semestre de ingresso na ESS', 'class' => 'col-3'], 'between' => '<div class = "col-2">', 'value' => $ingresso, 'required', 'class' => 'form-control']);
} else {
    echo $this->Form->input('ingresso', ['type' => 'text', 'label' => ['text' => 'Ano e semestre de ingresso na ESS', 'class' => 'col-3'], 'between' => '<div class = "col-2">', 'value' => $ingresso, 'required', 'class' => 'form-control']);
}

if ($alunonovoturno) {
    echo $this->Form->input('alunonovoturno', ['type' => 'hidden', 'label' => ['text' => 'Turno', 'class' => 'col-3'], 'empty' => 'Seleciona', 'between' => '<div class = "col-2">', 'value' => $alunonovoturno, 'required', 'class' => 'form-control']);
} else {
    echo $this->Form->input('alunonovoturno', ['type' => 'select', 'label' => ['text' => 'Turno', 'class' => 'col-3'], 'options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno'], 'empty' => 'Seleciona', 'required', 'between' => '<div class = "col-2">', 'class' => 'form-control']);
}

echo $this->Form->input('ajuste2020', array('type' => 'select', 'label' => ['text' => 'Ajuste curricular 2020', 'class' => 'col-3'], 'options' => ['0' => 'Não', '1' => 'Sim'], 'value' => $ajuste2020, 'empty' => 'Seleciona', 'required', 'between' => '<div class = "col-2">', 'after' => '<small>Para ingressantes a partir de 2020 são 3 níves de estágio</small></div>'));

echo $this->Form->input('tipo_de_estagio', array('type' => 'select', 'label' => ['text' => 'Seleciona tipo de estágio', 'class' => 'col-3'], 'options' => [1 => 'Presencial', 2 => 'Remoto'], 'default' => '1', 'between' => '<div class = "col-2">', 'class' => 'form-control'));
?>

<fieldset class="border p-1">
    <legend class="w-auto">Benefícios</legend>
    <?php
    echo $this->Form->input('benetransporte', ['type' => 'select', 'label' => ['text' => 'A instituição oferece vale transporte?', 'class' => 'col-3'], 'options' => [1 => 'Sim', 0 => 'Não'], 'default' => '0', 'between' => '<div class = "col-2">', 'class' => 'form-control']);
    echo $this->Form->input('benealimentacao', ['type' => 'select', 'label' => ['text' => 'A instituição oferece alimentação?', 'class' => 'col-3'], 'options' => [1 => 'Sim', 0 => 'Não'], 'default' => '0', 'between' => '<div class = "col-2">', 'class' => 'form-control']);
    echo $this->Form->input('benebolsa', ['type' => 'text', 'label' => ['text' => 'Se a instituição oferece bolsa indique o valor em números inteiros, caso contrário digite o número 0', 'class' => 'col-3'], 'between' => '<div class = "col-2">', 'class' => 'form-control', 'required']);
    ?>
</fieldset>

<fieldset class="border p-2">
    <?php
    echo $this->Form->input('id_instituicao', array('type' => 'select', 'label' => ['text' => 'Instituição', 'class' => 'col-3'], 'options' => $instituicoes, 'empty' => ['0' => 'Selecione'], 'value' => $instituicao_atual, 'required', 'between' => '<div class ="col-9">', 'after' => '<small>É obrigatório selecionar uma instituição.</small></div>', 'class' => 'form-control'));
    echo $this->Form->input('id_supervisor', array('type' => 'select', 'label' => ['text' => 'Supervisor', 'class' => 'col-3'], 'options' => $supervisores, 'value' => $supervisor_atual, 'empty' => ['0' => 'Selecione'], 'between' => '<div class ="col-9">', 'after' => '<small>Se não souber quem é o(a) supervisor(a) pode deixar em branco</small></div>', 'class' => 'form-control'));
    ?>
</fieldset>

<div class='row justify-content-left'>
    <div class='col-auto'>
        <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']);
        ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>