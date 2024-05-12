<?php

// pr($avaliacao);
?>
<div class="table-responsive">

    <?= $this->element('submenu_avaliacoes'); ?>

    <p>
        <?php echo __('Estagiário(a): '); ?>
        <?php echo $this->Html->link($avaliacao['Estagiario']['Aluno']['nome'], array('controller' => 'estagiarios', 'action' => 'view', $avaliacao['Estagiario']['id']), 'readonly'); ?>
        &nbsp;
        <?php
        echo __('Supervisor(a): ');
        if (isset($avaliacao['Estagiario']['Supervisor']['nome'])) {
            echo $this->Html->link($avaliacao['Estagiario']['Supervisor']['nome'], array('controller' => 'supervisors', 'action' => 'view', $avaliacao['Estagiario']['id_supervisor']), 'readonly');
        } else {
            echo $this->Html->link('Sem supervisora?', array('controller' => 'estagiarios', 'action' => 'view', $avaliacao['Estagiario']['id']), 'readonly');
        }
        ?>
    </p>

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
            <td><?= $avaliacao['Estagiario']['periodo'] ?></td>
            <td><?= $avaliacao['Estagiario']['Complemento']['periodo_especial'] = isset($avaliacao['Estagiario']['Complemento']['periodo_especial']) ? $avaliacao['Estagiario']['Complemento']['periodo_especial'] : NULL ?></td>
            <td><?= $avaliacao['Estagiario']['nivel'] ?></td>
            <td><?= $avaliacao['Estagiario']['Instituicao']['instituicao'] = isset($avaliacao['Estagiario']['Instituicao']['instituicao']) ? $avaliacao['Estagiario']['Instituicao']['instituicao'] : NULL ?></td>
            <td><?= $avaliacao['Estagiario']['Supervisor']['cress'] = isset($avaliacao['Estagiario']['Supervisor']['cress']) ? $avaliacao['Estagiario']['Supervisor']['cress'] : NULL ?></td>
            <td><?= $avaliacao['Estagiario']['Supervisor']['nome'] = isset($avaliacao['Estagiario']['Supervisor']['nome']) ? $avaliacao['Estagiario']['Supervisor']['nome'] : NULL ?></td>
            <td><?= $avaliacao['Estagiario']['Professor']['nome'] = isset($avaliacao['Estagiario']['Professor']['nome']) ? $avaliacao['Estagiario']['Professor']['nome'] : NULL ?></td>
        </tr>
    </table>

    <h2><?php echo __('Avaliação'); ?></h2>

    <dl>

        <dt class="col-9"><?php echo __('Desempenho discente no espaço ocupacional'); ?></dt>
        
        <dt class="col-9"><?php echo __('1) Sobre assiduidade: manteve a frequência, ausentando-se apenas com conhecimento da supervisão de campo e acadêmica, seja por motivo de saúde ou por situações estabelecidas na Lei 11788/2008, entre outras:'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao1']):
                case 0:
                    echo "Ruim";
                    break;
                case 1:
                    echo "Regular";
                    break;
                case 2:
                    echo "Bom";
                    break;
                case 3:
                    echo "Excelente";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('2) Sobre pontualidade: cumpre o horário estabelecido no Plano de Estágio:'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao2']):
                case 0:
                    echo "Ruim";
                    break;
                case 1:
                    echo "Regular";
                    break;
                case 2:
                    echo "Bom";
                    break;
                case 3:
                    echo "Excelente";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>

        </dd>

        <dt class="col-9"><?php echo __('3) Sobre compromisso: possui compromisso com as ações e estratégias previstas no Plano de Estágio:'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao3']):
                case 0:
                    echo "Ruim";
                    break;
                case 1:
                    echo "Regular";
                    break;
                case 2:
                    echo "Bom";
                    break;
                case 3:
                    echo "Excelente";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>

        </dd>

        <dt class="col-9"><?php echo __('4) Na relação com usuários(as): compromisso ético-político no atendimento:'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao4']):
                case 0:
                    echo "Ruim";
                    break;
                case 1:
                    echo "Regular";
                    break;
                case 2:
                    echo "Bom";
                    break;
                case 3:
                    echo "Excelente";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>

        </dd>

        <dt class="col-9"><?php echo __('5) Na relação com profissionais: integração e articulação à equipe de estágio, cooperação e habilidade para trabalhar em equipe multiprofissional:'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao5']):
                case 0:
                    echo "Ruim";
                    break;
                case 1:
                    echo "Regular";
                    break;
                case 2:
                    echo "Bom";
                    break;
                case 3:
                    echo "Excelente";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>

        </dd>

        <dt class="col-9"><?php echo __('6) Sobre criticidade e iniciativa: possui capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao6']):
                case 0:
                    echo "Ruim";
                    break;
                case 1:
                    echo "Regular";
                    break;
                case 2:
                    echo "Bom";
                    break;
                case 3:
                    echo "Excelente";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('7) Apreensão do referencial teórico-metodológico, ético-político e investigativo, e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao7']):
                case 0:
                    echo "Ruim";
                    break;
                case 1:
                    echo "Regular";
                    break;
                case 2:
                    echo "Bom";
                    break;
                case 3:
                    echo "Excelente";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>

        </dd>

        <dt class="col-9"><?php echo __('8) Avaliação do desempenho na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao8']):
                case 0:
                    echo "Ruim";
                    break;
                case 1:
                    echo "Regular";
                    break;
                case 2:
                    echo "Bom";
                    break;
                case 3:
                    echo "Excelente";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('9) O plano de estágio foi elaborado pela supervisão de campo, estudante e com apoio da supervisão acadêmica no início do semestre?'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao9']):
                case 0:
                    echo "Sim";
                    break;
                case 1:
                    echo "Não";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('10) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao10']):
                case 0:
                    echo "Sim";
                    break;
                case 1:
                    echo "Não";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('11) O desempenho das atividades desenvolvidas pelo/a discente e o processo de supervisão foram afetados pelas condições de trabalho?'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao11']):
                case 0:
                    echo "Sim";
                    break;
                case 1:
                    echo "Não";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

    </dl>

    <dl>
        <dt class="col-9">Relação interinstitucional</dt>

        <dt class="col-9"><?php echo __('1) Quanto à integração sala de aula/campo de estágio, houve alguma interlocução entre discente, docente e supervisão de campo?'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao12']):
                case 0:
                    echo "Sim";
                    break;
                case 1:
                    echo "Não";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('2) Quanto à integração Coordenação de estágio/campo de estágio: houve algum tipo de interlocução?'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao13']):
                case 0:
                    echo "Sim";
                    break;
                case 1:
                    echo "Não";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('3) Você tomou conhecimento do conteúdo da Disciplina de OTP?'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao14']):
                case 0:
                    echo "Sim";
                    break;
                case 1:
                    echo "Não";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('4) Você participou de alguma atividade promovida e/ou convocada por docente ou Coordenação de Estágio (reuniões, Fórum Local de Estágio, cursos, eventos, entre outros)?'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao15']):
                case 0:
                    echo "Sim";
                    break;
                case 1:
                    echo "Não";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('Caso positivo, por favor, informe qual:'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao15_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao15_1'], 'readonly']); ?>
            &nbsp;
        </dd>

        <dt class="col-9"><?php echo __('5) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?'); ?></dt>
        <dd class="col-3">
            <?php
            switch ($avaliacao['Avaliacao']['avaliacao16']):
                case 0:
                    echo "Sim";
                    break;
                case 1:
                    echo "Não";
                    break;
                default:
                    echo "Sem avaliação";
                    break;
            endswitch;
            ?>
        </dd>

        <dt class="col-9"><?php echo __('Caso positivo, por favor, informe quais:'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao16_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao16_1'], 'readonly']); ?>
            &nbsp;
        </dd>

        <dt class="col-9"><?php echo __('De modo geral, como avalia a experiência do estágio neste semestre? Será possível a continuidade no próximo? Aproveite este espaço para deixar suas críticas, sugestões e/ou observações:'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao17', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao17'], 'readonly']); ?>
            &nbsp;
        </dd>

    </dl>

</div>
<!--
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Avaliacao'), array('action' => 'edit', $avaliacao['Avaliacao']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Avaliacao'), array('action' => 'delete', $avaliacao['Avaliacao']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $avaliacao['Avaliacao']['id']))); ?> </li>
        <li><?php echo $this->Html->link(__('List Avaliacoes'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Avaliacao'), array('action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Estagiarios'), array('controller' => 'estagiarios', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Estagiario'), array('controller' => 'estagiarios', 'action' => 'add')); ?> </li>
        </ul>
</div>
//-->