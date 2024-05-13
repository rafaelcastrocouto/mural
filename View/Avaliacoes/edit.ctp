<?php

// setlocale (LC_TIME, 'pt_BR');
$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());
// pr($estagiario);
// die();
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

    <h1>Formulário de avalição da(o) discente <?= $estagiario['Estagiario']['Aluno']['nome'] ?></h1>

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

    <fieldset class="border p-2">

        <legend class="w-auto">Desempenho discente no espaço ocupacional</legend>

        <?= $this->Form->input('id', ['type' => 'hidden']); ?>
        <?= $this->Form->input('estagiario_id', ['type' => 'hidden']); ?>

        <legend style='font-size: 90%'>
            1) Sobre assiduidade: manteve a frequência, ausentando-se apenas com conhecimento da supervisão de campo e acadêmica, seja por motivo de saúde ou por situações estabelecidas na Lei 11788/2008, entre outras:
        </legend>
        <?= $this->Form->input('avaliacao1', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao1'], 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            2) Sobre pontualidade: cumpre o horário estabelecido no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao2', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao2'], 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            3) Sobre compromisso: possui compromisso com as ações e estratégias previstas no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao3', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao3'], 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            4) Na relação com usuários(as): compromisso ético-político no atendimento:
        </legend>
        <?= $this->Form->input('avaliacao4', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao4'], 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            5) Na relação com profissionais: integração e articulação à equipe de estágio, cooperação e habilidade para trabalhar em equipe multiprofissional:
        </legend>
        <?= $this->Form->input('avaliacao5', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao5'], 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            6) Sobre criticidade e iniciativa: possui capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:
        </legend>
        <?= $this->Form->input('avaliacao6', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao6'], 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            7) Apreensão do referencial teórico-metodológico, ético-político e investigativo, e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao7', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao7'], 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            8)  Avaliação do desempenho na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:
        </legend>
        <?= $this->Form->input('avaliacao8', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao8'], 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            9) O plano de estágio foi elaborado pela supervisão de campo, estudante e com apoio da supervisão acadêmica no início do semestre?
        </legend>
        <?= $this->Form->input('avaliacao9', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao9'], 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            10) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?
        </legend>
        <?= $this->Form->input('avaliacao10', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao10'] ,'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            11) O desempenho das atividades desenvolvidas pelo/a discente e o processo de supervisão foram afetados pelas condições de trabalho?
        </legend>
        <?= $this->Form->input('avaliacao11', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao11'], 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

    </fieldset>

    <fieldset class="border p-2">

        <legend class="w-auto">Relação interinstitucional</legend>

        <legend style='font-size: 90%'>
            1) Quanto à integração sala de aula/campo de estágio, houve alguma interlocução entre discente, docente e supervisão de campo?
        </legend>
        <?= $this->Form->input('avaliacao12', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao12'], 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            2) Quanto à integração Coordenação de estágio/campo de estágio: houve algum tipo de interlocução?
        </legend>
        <?= $this->Form->input('avaliacao13', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao13'], 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            3) Você tomou conhecimento do conteúdo da Disciplina de OTP?
        </legend>
        <?= $this->Form->input('avaliacao14', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao14'], 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            4) Você participou de alguma atividade promovida e/ou convocada por docente ou Coordenação de Estágio (reuniões, Fórum Local de Estágio, cursos, eventos, entre outros)?
        </legend>
        <?= $this->Form->input('avaliacao15', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao15'], 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Caso positivo, por favor, informe qual:
            <?= $this->Form->input('avaliacao15_1', ['type' => 'textarea', 'label' => false, 'value' => $estagiario['Avaliacao']['avaliacao15_1'], 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
        </p>

        <legend style='font-size: 90%'>
            5) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?
        </legend>
       <?= $this->Form->input('avaliacao16', ['div' => 'form-check form-check-inline', 'separator' => '&nbsp', 'type' => 'radio', 'legend' => false, 'value' => $estagiario['Avaliacao']['avaliacao16'], 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Caso positivo, por favor, informe quais:
        </p>
        <?= $this->Form->input('avaliacao16_1', ['type' => 'textarea', 'label' => false, 'value' => $estagiario['Avaliacao']['avaliacao16_1'], 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

        <p>
            6) De modo geral, como avalia a experiência do estágio neste semestre? Será possível a continuidade no próximo? Aproveite este espaço para deixar suas críticas, sugestões e/ou observações:
        </p>
        <?= $this->Form->input('avaliacao17', ['type' => 'textarea', 'label' => false, 'value' => $estagiario['Avaliacao']['avaliacao17'], 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

    </fieldset>

    <br />
    <br />
    
    <p style="text-align:right; line-height:100%; font-size: 90%;">Rio de Janeiro, <?= $dia; ?> de <?= $mes; ?> de <?= $ano; ?></p>

    <br />
    <br />

    <div class='row justify-content-center'>
        <div class='col-auto'>
            <table class='table table-responsive table-borderless'>
                <tr>
                    <td><span style="font-size: 90%; text-decoration: overline;"><?= $estagiario['Estagiario']['Supervisor']['nome']; ?></span></td>
                    <td><span style="font-size: 90%; text-decoration: overline;"><?= $estagiario['Estagiario']['Alunonovo']['nome']; ?></span></td>
                    <td><span style="font-size: 90%; text-decoration: overline;"><?= $estagiario['Estagiario']['Professor']['nome']; ?></span></td>
                </tr>

                <tr>
                    <td><span style="font-size: 90%;">CRESS: <?= isset($estagiario['Estagiario']['Supervisor']['cress']) ? $estagiario['Estagiario']['Supervisor']['cress'] : NULL; ?></span></td>
                    <td><span style="font-size: 90%;">DRE: <?= $estagiario['Estagiario']['Alunonovo']['registro']; ?></span></td>
                    <td><span style="font-size: 90%;">CRESS: <?= isset($estagiario['Estagiario']['Professor']['cress']) ? $estagiario['Estagiario']['Professor']['cress'] : NULL; ?></span></td>
                </tr>

                <tr>
                    <td>Supervisor(a) de campo</td>
                    <td>Discente</td>
                    <td>Supervisor(a) acadêmica</td>
                </tr>
            </table>
        </div>
    </div>

    <div class='row justify-content-center'>
        <div class='col-auto'>
            <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
