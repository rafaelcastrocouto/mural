<?php ?>

<?= $this->Html->script("jquery.maskedinput") ?>

<script>

    $(document).ready(function () {

        $("#SupervisorTelefone").mask("9999.9999");
        $("#SupervisorCelular").mask("99999.9999");

    });

</script>

<div class='table-responsive'>

    <?= $this->element('submenu_alunos') ?>

    <table class='table table-hover table-striped table-responsive'>
        <tr>
            <td>Estudante:</td><td><?php echo $aluno; ?></td>
        </tr>
        <tr>
            <td>Registro:</td><td><?php echo $registro; ?></td>
        </tr>
        <tr>
            <td>Período:</td><td><?php echo $periodo; ?></td>
        </tr>
        <tr>
            <td>Nível:</td><td><?php echo $nivel; ?></td>
        </tr>
        <tr>
            <td>Professor:</td><td><?php echo $professor; ?></td>
        </tr>
        <tr>
            <td>Instituição:</td><td><?php echo $instituicao; ?></td>
        </tr>
        <tr>
            <td>Supervisor:</td><td><?php echo $supervisor; ?></td>
        </tr>
    </table>

</div>

<h1>Preencha todos os campos do formulário</h1>

<?php
// die();
echo $this->Form->create('Supervisor', [
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

echo $this->Form->input('regiao', array('label' => ['text' => 'Região', 'class' => 'col-4'], 'default'=>7));
echo $this->Form->input('cress');
echo $this->Form->input('nome');
?>

<?php
echo $this->Form->input('codigo_tel', array('value'=>21));
echo $this->Form->input('telefone');
echo $this->Form->input('codigo_cel', array('value'=>21));
echo $this->Form->input('celular');
echo $this->Form->input('email');
?>

<?php
echo $this->Form->input('registro', array('type' => 'hidden', 'value' => $registro));
echo $this->Form->input('supervisor_id', array('type' => 'hidden', 'value' => $supervisor_id));
?>

<?php
echo $this->Form->create('Avaliacao', [
  'class' => 'form-horizontal',
  'role' => 'form',
    'inputDefaults' => [
        'format' => ['before', 'label', 'input', 'error'],
        'div' => ['class' => 'form-check form-check-inline'],
        'label' => ['class' => 'form-check-label'],
        'class' => ['form-check-input'],
        'error' => false
    ]
]);
?>
<fieldset>
    <legend style='font-size: 90%'>
        1) ASSIDUIDADE: Desenvolveu as atividades propostas com frequência, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras:
    </legend>
<?= $this->Form->input('avaliacao1', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruin', 1 => 'Regular', 2 => 'Bom', 3 => 'Exelente']]); ?>

    <legend style='font-size: 90%'>
        2) PONTUALIDADE: cumpre horário estabelecido no Plano de Estágio:
    </legend>
<?= $this->Form->input('avaliacao2', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruin', 1 => 'Regular', 2 => 'Bom', 3 => 'Exelente']]); ?>

    <legend style='font-size: 90%'>
        3) COMPROMISSO: com as ações e estratégias previstas no Plano de Estágio:
    </legend>
<?= $this->Form->input('avaliacao3', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruin', 1 => 'Regular', 2 => 'Bom', 3 => 'Exelente']]); ?>

    <legend style='font-size: 90%'>
        4) Na relação com o(a) usuário(a): compromisso ético-político no atendimento ao usuário(a):
    </legend>
<?= $this->Form->input('avaliacao4', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruin', 1 => 'Regular', 2 => 'Bom', 3 => 'Exelente']]); ?>

    <legend style='font-size: 90%'>
        5) Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional:
    </legend>
<?= $this->Form->input('avaliacao5', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruin', 1 => 'Regular', 2 => 'Bom', 3 => 'Exelente']]); ?>

    <legend style='font-size: 90%'>
        6) CRITICIDADE E INICATIVA: Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:
    </legend>
<?= $this->Form->input('avaliacao6', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruin', 1 => 'Regular', 2 => 'Bom', 3 => 'Exelente']]); ?>

    <legend style='font-size: 90%'>
        7) Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:
    </legend>
<?= $this->Form->input('avaliacao7', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruin', 1 => 'Regular', 2 => 'Bom', 3 => 'Exelente']]); ?>

    <legend style='font-size: 90%'>
        8)  Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:
    </legend>
<?= $this->Form->input('avaliacao8', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruin', 1 => 'Regular', 2 => 'Bom', 3 => 'Exelente']]); ?>

    <legend style='font-size: 90%'>
        9)  As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?
    </legend>
<?= $this->Form->input('avaliacao9', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

    <p>
        Fundamente se achar necessário:
        <?= $this->Form->input('avaliacao9-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
    </p>

    <legend style='font-size: 90%'>
        10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular, pelas condições estabelecidas pelo estágio remoto?
    </legend>
    <?= $this->Form->input('avaliacao10', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

    <p>
        Justifique a resposta se achar necessário:
    </p>
        <?= $this->Form->input('avaliacao10-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

    <legend style='font-size: 90%'>
        11) Quanto à integração Disciplina de OTP/Coordenação de Estágio da ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a), professor(a) e supervisor(a)?
    </legend>
    <?= $this->Form->input('avaliacao11', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

    <p>
        Como você avalia esta interação? (Responda se achar necessário)
    </p>
        <?= $this->Form->input('avaliacao11-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

    <legend style='font-size: 90%'>
        12) Você recebeu e acompanhou os programa de da Disciplina OTP?
    </legend>
    <?= $this->Form->input('avaliacao12', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

    <p>
        Sugestões ao que foi desenvolvido?
    </p>
        <?= $this->Form->input('avaliacao12-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

    <legend style='font-size: 90%'>
        13) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?
    </legend>
    <?= $this->Form->input('avaliacao13', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

    <p>
        Se sim, quais?
    </p>
        <?= $this->Form->input('avaliacao13-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

    <p>
        14) Como avalia a experiência do estágio remoto neste semestre? Será possível a continuidade do estágio na modalidade remota no próximo semestre?
    </p>
        <?= $this->Form->input('avaliacao14', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

    <p>
        Sugestões e observações:
    </p>
        <?= $this->Form->input('observacoes', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

</fieldset>

<p style="text-align:right; line-height:100%; font-size: 90%;">Rio de Janeiro, <?= $dia; ?> de <?= $mes; ?> de <?= $ano; ?></p>

<br />
<br />
<br />
<br />

<table class='table table-responsive'>
    <tr>
        <td><span style="font-size: 90%; text-decoration: overline;">Coordenação de Estágio</span></td>
        <td><span style="font-size: 90%; text-decoration: overline;"><?= $estudante; ?></span></td>
        <td><span style="font-size: 90%; text-decoration: overline;"><?= $supervisor; ?></span></td>
    </tr>

    <tr>
        <td>Escola de Serviço Social</td>
        <td><span style="font-size: 90%;">DRE: <?= $registro; ?></span></td>
        <td><span style="font-size: 90%;">CRESS 7ª Região: <?= $cress; ?></span></td>
    </tr>

    <tr>
        <td>UFRJ</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>

</table>

<div class='row justify-content-center'>
    <div class='col-auto'>
    <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
    <?= $this->Form->end(); ?>
    </div>
</div>
