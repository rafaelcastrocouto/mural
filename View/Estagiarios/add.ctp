<?php
// pr($proximo_nivel);
// pr($estagiarios);
$estagiario = end($estagiarios);
// pr($estagiario['Estagiario']['nivel']);
?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(["controller" => "Instituicaos", "action" => "seleciona_supervisor"]); ?>";

        $("#EstagiarioIdInstituicao").change(function () {
            var id_instituicao = $(this).val();
            /* alert(id_instituicao); */
            $("#EstagiarioIdSupervisor").load(base_url + "/" + id_instituicao);
            // alert(id_instituicao); */
        })
    });

    $(document).ready(function () {

        $("#EstagiarioNota").mask("99.99");
        $("#EstagiarioCh").mask("999");

    });

</script>

<?= $this->element('submenu_estagiarios') ?>

<?php if (isset($estagiarios)): ?>
    <div class="table-responsive">
        <table class='table table-striped table-hover table-responsive'>
            <caption style='caption-side: top'>Estágios cursados</caption>
            <thead class='thead-light'>
                <tr>
                    <th>Excluir</th>
                    <th>Editar</th>
                    <th>Período</th>
                    <th>Modalidade período especial</th>
                    <th>Nível</th>
                    <th>Ajuste 2020</th>
                    <th>Turno</th>
                    <th>TC</th>
                    <th>Solicitação do TC</th>
                    <th>Instituição</th>
                    <th>Supervisor</th>
                    <th>Professor</th>
                    <th>Área</th>
                    <th>Nota</th>
                    <th>CH</th>
                </tr>
            <thead>
                <?php foreach ($estagiarios as $c_estagio): ?>
                    <tr>
                        <td>
                            <?php echo $this->Html->link('Excluir', '/Estagiarios/delete/' . $c_estagio['Estagiario']['id'], NULL, 'Tem certeza?'); ?>
                        </td>
                        <td>
                            <?php echo $this->Html->link('Editar', '/Estagiarios/view/' . $c_estagio['Estagiario']['id']); ?>
                        </td>
                        <td><?php echo $c_estagio['Estagiario']['periodo'] ?></td>
                        <td><?php echo $c_estagio['Estagiario']['complemento_id'] ?></td>
                        <td><?php echo $c_estagio['Estagiario']['nivel']; ?></td>
                        <td><?php echo $c_estagio['Estagiario']['ajuste2020']; ?></td>
                        <td><?php echo $c_estagio['Estagiario']['turno']; ?></td>
                        <td><?php echo $c_estagio['Estagiario']['tc']; ?></td>
                        <td><?php echo $c_estagio['Estagiario']['tc_solicitacao']; ?></td>
                        <td><?php echo $c_estagio['Instituicao']['instituicao'] ?></td>
                        <td><?php echo $c_estagio['Supervisor']['nome'] ?></td>
                        <td><?php echo $c_estagio['Professor']['nome'] ?></td>
                        <td><?php echo $c_estagio['Area']['area'] ?></td>
                        <td><?php echo $c_estagio['Estagiario']['nota'] ?></td>
                        <td><?php echo $c_estagio['Estagiario']['ch'] ?></td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </div>

<?php endif; ?>

<h1>Inserir estágio</h1>

<?php
echo $this->Form->create('Estagiario', [
    'class' => 'form-horizontal was-validated',
    'role' => 'form',
    'inputDefaults' => [
        'format' => ['before', 'label', 'between', 'input', 'error', 'after'],
        'div' => ['class' => 'form-group row'],
        'label' => ['class' => 'col-4'],
        'between' => "<div class = 'col-8'>",
        'class' => ['form-control'],
        'after' => "<div class='valid-feedback'>Válido.</div>
    <div class='invalid-feedback'>Digite um valor correto neste campo.</div>
    </div>",
        'error' => ['attributes' => ['wrap' => 'span', 'class' => 'help-inline']]
    ]
]);
?>

<?php echo $this->Form->input('Estagiario.periodo', array('label' => ['text' => 'Período', 'class' => 'col-4'], 'options' => $periodos, 'default' => $periodo_atual)); ?>
<?php echo $this->Form->input('Estagiario.complemento_id', array('label' => ['text' => 'Modalidade período especial', 'class' => 'col-4'], 'options' => $complemento_periodo_especial_total, 'empty' => ['Seleciona'])); ?>
<?php echo $this->Form->input('Estagiario.nivel', array('label' => ['text' => 'Nível', 'class' => 'col-4'], 'options' => array('1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '9' => 'Não obrigatório'), 'selected' => $proximo_nivel)); ?>
<?php echo $this->Form->input('Estagiario.ajuste2020', array('label' => ['text' => 'Ajuste 2020', 'class' => 'col-4'], 'options' => ['0' => 'Não', '1' => 'Sim'])); ?>
<?php echo $this->Form->input('Estagiario.turno', array('label' => ['text' => 'Turno', 'class' => 'col-4'], 'options' => ['D' => 'Diurno', 'N' => 'Noturno'], 'default' => 'I')); ?>
<?php echo $this->Form->input('Estagiario.tc', array('label' => ['text' => 'TC (Aluno entrogou o TC assinado na Coordenação de Estágio?', 'class' => 'col-4'], 'options' => array('0' => 'Não', '1' => 'Sim'))); ?>
<?php echo $this->Form->input('Estagiario.tc_solicitacao', array('type' => 'hidden', 'label' => ['text' => 'Data de solicitação do TC', 'class' => 'col-4'], 'dateFormat' => 'DMY', 'empty' => TRUE)); ?>
<?php echo $this->Form->input('Estagiario.id_instituicao', array('label' => ['text' => 'Instituição', 'class' => 'col-4'], 'options' => $instituicoes, 'empty' => TRUE, 'default' => $estagiarios[count($estagiarios) - 1]['Instituicao']['id'])); ?>
<?php echo $this->Form->input('Estagiario.id_supervisor', array('label' => ['text' => 'Supervisor', 'class' => 'col-4'], 'options' => $supervisores, 'empty' => TRUE, 'default' => $estagiarios[count($estagiarios) - 1]['Supervisor']['id'])); ?>
<?php echo $this->Form->input('Estagiario.id_professor', array('label' => ['text' => 'Professor', 'class' => 'col-4'], 'options' => $professores, 'empty' => TRUE, 'default' => $estagiarios[count($estagiarios) - 1]['Professor']['id'])); ?>
<?php echo $this->Form->input('Estagiario.id_area', array('label' => ['text' => 'Área temática', 'class' => 'col-4'], 'options' => $areas, 'empty' => TRUE, 'default' => $estagiarios[count($estagiarios) - 1]['Area']['id'])); ?>
<?php echo $this->Form->input('Estagiario.nota', ['type' => 'number', 'step' => '0.01', 'min' => '0', 'max' => '10', 'label' => ['text' => 'Nota', 'class' => 'col-4']]); ?>
<?php echo $this->Form->input('Estagiario.ch', array('type' => 'text', 'label' => ['text' => 'Carga horária (Digitar números inteiros)', 'class' => 'col-4'])); ?>
<?php echo $this->Form->input('Estagiario.observacoes', array('label' => ['text' => 'Observações', 'class' => 'col-4'])); ?>
<?php echo $this->Form->input('Estagiario.id_aluno', array('type' => 'hidden', 'value' => $estagiario['Estagiario']['id_aluno'])); ?>
<?php echo $this->Form->input('Estagiario.alunonovo_id', array('type' => 'hidden', 'value' => $estagiario['Alunonovo']['id'])); ?>
<?php echo $this->Form->input('Estagiario.registro', array('type' => 'hidden', 'value' => $estagiario['Estagiario']['registro'])); ?>
<?php
$estagio = end($estagiarios);
// pr($estagio['Estagiario']['nivel']);
// pr($proximo_nivel);
if (($estagio['Estagiario']['nivel']) == $proximo_nivel):
    // echo "Mesmo nivel";
    echo $this->Form->input('Estagiario.id', array('type' => 'hidden', 'value' => $estagiario['Estagiario']['id']));
else:
    echo $this->Form->input('Estagiario.id', array('type' => 'hidden', 'value' => NULL));
endif;
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
