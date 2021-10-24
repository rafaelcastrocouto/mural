<?php
// setlocale (LC_TIME, 'pt_BR');
$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());
// pr($estagiario);
?>
<div class="table-responsive">
    <?= $this->element('submenu_avaliacoes'); ?>

    <table class="table table-responsive">
        <tr>
            <th>Período</th>
            <th>Complemento</th>
            <th>Nível</th>
            <th>Instituição</th>
            <th>Supervisor(a)</th>
            <th>Professor(a)</th>
        </tr>
        <tr>
            <td><?= $estagiario['Estagiario']['periodo'] ?></td>
            <td><?= $estagiario['Estagiario']['Complemento']['periodo_especial'] = isset($estagiario['Estagiario']['Complemento']['periodo_especial']) ? $estagiario['Estagiario']['Complemento']['periodo_especial'] : NULL ?></td>
            <td><?= $estagiario['Estagiario']['nivel'] ?></td>
            <td><?= $estagiario['Estagiario']['Instituicao']['instituicao'] = isset($estagiario['Estagiario']['Instituicao']['instituicao']) ? $estagiario['Estagiario']['Instituicao']['instituicao'] : NULL ?></td>
            <td><?= $estagiario['Estagiario']['Supervisor']['nome'] = isset($estagiario['Estagiario']['Supervisor']['nome']) ? $estagiario['Estagiario']['Supervisor']['nome'] : NULL ?></td>
            <td><?= $estagiario['Estagiario']['Professor']['nome'] = isset($estagiario['Estagiario']['Professor']['nome']) ? $estagiario['Estagiario']['Professor']['nome'] : NULL ?></td>
        </tr>
    </table>

    <h1>Formulário de avalição do discente <?= $estagiario['Estagiario']['Aluno']['nome'] ?></h1>

    <?php
    echo $this->Form->create('Avaliacao', [
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => [
            'format' => ['before', 'after', 'label', 'input', 'error'],
            'label' => ['class' => 'form-check-label'],
            'class' => ['form-check-input'],
            'error' => false
        ]
    ]);
    ?>
    <fieldset>

        <?= $this->Form->input('id', ['type' => 'hidden']); ?>
        <?= $this->Form->input('estagiario_id', ['type' => 'hidden']); ?>

        <legend style='font-size: 90%'>
            1) ASSIDUIDADE: Desenvolveu as atividades propostas com frequência, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras:
        </legend>
        <?= $this->Form->input('avaliacao1', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            2) PONTUALIDADE: cumpre horário estabelecido no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao2', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            3) COMPROMISSO: com as ações e estratégias previstas no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao3', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            4) Na relação com o(a) usuário(a): compromisso ético-político no atendimento ao usuário(a):
        </legend>
        <?= $this->Form->input('avaliacao4', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            5) Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional:
        </legend>
        <?= $this->Form->input('avaliacao5', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            6) CRITICIDADE E INICATIVA: Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:
        </legend>
        <?= $this->Form->input('avaliacao6', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            7) Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao7', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            8)  Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:
        </legend>
        <?= $this->Form->input('avaliacao8', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            9)  As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?
        </legend>
        <?= $this->Form->input('avaliacao9', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Fundamente se achar necessário:
            <?= $this->Form->input('avaliacao9_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
        </p>

        <legend style='font-size: 90%'>
            10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular, pelas condições estabelecidas pelo estágio remoto?
        </legend>
        <?= $this->Form->input('avaliacao10', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Justifique a resposta se achar necessário:
        </p>
        <?= $this->Form->input('avaliacao10_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

        <legend style='font-size: 90%'>
            11) Quanto à integração Disciplina de OTP/Coordenação de Estágio da ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a), professor(a) e supervisor(a)?
        </legend>
        <?= $this->Form->input('avaliacao11', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Como você avalia esta interação? (Responda se achar necessário)
        </p>
        <?= $this->Form->input('avaliacao11_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

        <legend style='font-size: 90%'>
            12) Você recebeu e acompanhou o programa da Disciplina OTP?
        </legend>
        <?= $this->Form->input('avaliacao12', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Sugestões ao que foi desenvolvido?
        </p>
        <?= $this->Form->input('avaliacao12_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

        <legend style='font-size: 90%'>
            13) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?
        </legend>
        <?= $this->Form->input('avaliacao13', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Se sim, quais?
        </p>
        <?= $this->Form->input('avaliacao13_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

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
            <td><span style="font-size: 90%; text-decoration: overline;"><?= $estagiario['Estagiario']['Aluno']['nome']; ?></span></td>
            <td><span style="font-size: 90%; text-decoration: overline;"><?= $estagiario['Estagiario']['Supervisor']['nome']; ?></span></td>
        </tr>

        <tr>
            <td>Escola de Serviço Social</td>
            <td><span style="font-size: 90%;">DRE: <?= $estagiario['Estagiario']['Aluno']['registro']; ?></span></td>
            <td><span style="font-size: 90%;">CRESS 7ª Região: <?= $estagiario['Estagiario']['Supervisor']['cress']; ?></span></td>
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
</div>
