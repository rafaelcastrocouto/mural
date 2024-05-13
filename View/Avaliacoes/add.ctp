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
            <th>CRESS</th>
            <th>Supervisor(a)</th>
            <th>Professor(a)</th>
        </tr>
        <tr>
            <td><?= $estagiario['Estagiario']['periodo'] ?></td>
            <td><?= $estagiario['Complemento']['periodo_especial'] ?></td>
            <td><?= $estagiario['Estagiario']['nivel'] ?></td>
            <td><?= $estagiario['Instituicao']['instituicao'] ?></td>
            <td><?= $estagiario['Supervisor']['cress'] ?></td>
            <td><?= $estagiario['Supervisor']['nome'] ?></td>
            <td><?= $estagiario['Professor']['nome'] ?></td>
        </tr>
    </table>

    <h1>Formulário de avalição da(o) discente <?= $estagiario['Aluno']['nome'] ?></h1>

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
    <fieldset class="border p-2">
        
        
        <?= $this->Form->input('estagiario_id', ['type' => 'hidden', 'value' => $estagiario_id]); ?>

        <legend class="w-auto">Desempenho discente no espaço ocupacional</legend>
        
        <legend style='font-size: 90%'>
            1) Sobre assiduidade: manteve a frequência, ausentando-se apenas com conhecimento da supervisão de campo e acadêmica, seja por motivo de saúde ou por situações estabelecidas na Lei 11788/2008, entre outras:
        </legend>
        <?= $this->Form->input('avaliacao1', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            2) Sobre pontualidade: cumpre o horário estabelecido no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao2', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            3) Sobre compromisso: possui compromisso com as ações e estratégias previstas no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao3', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            4 ) Na relação com usuários(as): compromisso ético-político no atendimento:
        </legend>
        <?= $this->Form->input('avaliacao4', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            5) Na relação com profissionais: integração e articulação à equipe de estágio, cooperação e habilidade para trabalhar em equipe multiprofissional:
        </legend>
        <?= $this->Form->input('avaliacao5', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            6) Sobre criticidade e iniciativa: possui capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:
        </legend>
        <?= $this->Form->input('avaliacao6', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            7) Apreensão do referencial teórico-metodológico, ético-político e investigativo, e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:
        </legend>
        <?= $this->Form->input('avaliacao7', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            8)  Avaliação do desempenho na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:
        </legend>
        <?= $this->Form->input('avaliacao8', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

        <legend style='font-size: 90%'>
            9) O plano de estágio foi elaborado pela supervisão de campo, estudante e com apoio da supervisão acadêmica no início do semestre?
        </legend>
        <?= $this->Form->input('avaliacao9', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            10) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?
        </legend>
        <?= $this->Form->input('avaliacao10', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            11) O desempenho das atividades desenvolvidas pelo/a discente e o processo de supervisão foram afetados pelas condições de trabalho?
        </legend>
        <?= $this->Form->input('avaliacao11', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
    </fieldset>

    <fieldset class="border p-2">
        
        <legend class="w-auto">Relação interinstitucional</legend>
        
        <legend style='font-size: 90%'>
            1) Quanto à integração sala de aula/campo de estágio, houve alguma interlocução entre discente, docente e supervisão de campo?
        </legend>
       <?= $this->Form->input('avaliacao12', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            2) Quanto à integração Coordenação de estágio/campo de estágio: houve algum tipo de interlocução?
        </legend>
        <?= $this->Form->input('avaliacao13', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            3) Você tomou conhecimento do conteúdo da Disciplina de OTP?
        </legend>
       <?= $this->Form->input('avaliacao14', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <legend style='font-size: 90%'>
            4) Você participou de alguma atividade promovida e/ou convocada por docente ou Coordenação de Estágio (reuniões, Fórum Local de Estágio, cursos, eventos, entre outros)?
        </legend>
       <?= $this->Form->input('avaliacao15', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Caso positivo, por favor, informe qual:
            <?= $this->Form->input('avaliacao15_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
        </p>

        <legend style='font-size: 90%'>
            5) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?
        </legend>
        <?= $this->Form->input('avaliacao16', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

        <p>
            Caso positivo, por favor, informe quais:
        </p>
        <?= $this->Form->input('avaliacao16_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

        <legend style='font-size: 90%'>
            6) De modo geral, como avalia a experiência do estágio neste semestre? Será possível a continuidade no próximo? Aproveite este espaço para deixar suas críticas, sugestões e/ou observações:
        </legend>
        <?= $this->Form->input('avaliacao17', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

    </fieldset>

    <br />
    <br />

    <p style="text-align:right; line-height:100%; font-size: 90%;">Rio de Janeiro, <?= $dia; ?> de <?= $mes; ?> de <?= $ano; ?></p>

    <br />
    <br />

    <p>
        Assinam (este documento só pode ser entregue à Coordenação de Estágio após assinatura das partes abaixo):
    </p>

    <br />
    <br />

    <div class='row justify-content-center'>
        <div class='col-auto'>
            <table class='table table-responsive table-borderless'>
                <tr>
                    <td><span style="font-size: 90%; text-decoration: overline;"><?= isset($estagiario['Supervisor']['nome']) ? $estagiario['Supervisor']['nome'] : NULL; ?></span></td>
                    <td><span style="font-size: 90%; text-decoration: overline;"><?= $estagiario['Alunonovo']['nome']; ?></span></td>
                    <td><span style="font-size: 90%; text-decoration: overline;"><?= isset($estagiario['Professor']['nome']) ? $estagiario['Professor']['nome'] : NULL; ?><</span></td>
                </tr>

                <tr>
                    <td><span style="font-size: 90%;">CRESS: <?= isset($estagiario['Supervisor']['cress']) ? $estagiario['Supervisor']['cress'] . '/7ª região': NULL; ?></span></td>
                    <td><span style="font-size: 90%;">DRE: <?= $estagiario['Alunonovo']['registro']; ?></span></td>
                    <td><span style="font-size: 90%;">CRESS: <?= isset($estagiario['Professor']['cress']) ? $estagiario['Professor']['cress'] . '/' . $estagiario['Professor']['regiao'] . 'ª região': NULL; ?></span></td>
                </tr>

~                <tr>
                    <td>Supervisor(a) de campo</td>
                    <td>Discente</td>
                    <td>Supervisor(a) acadêmica</td>
                </tr>
            </table>
        </div>
    </div>

    <br />
    <br />

    <div class='row justify-content-center'>
        <div class='col-auto'>
            <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
