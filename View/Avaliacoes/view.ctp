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

    <dl class="row">
        <dt class="col-9"><?php echo __('1) ASSIDUIDADE: Desenvolveu as atividades propostas com frequência, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras:'); ?></dt>
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
        <dt class="col-9"><?php echo __('2) PONTUALIDADE: cumpre horário estabelecido no Plano de Estágio:'); ?></dt>
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
        <dt class="col-9"><?php echo __('3) COMPROMISSO: com as ações e estratégias previstas no Plano de Estágio:'); ?></dt>
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
        <dt class="col-9"><?php echo __('4) Na relação com o(a) usuário(a): compromisso ético-político no atendimento ao usuário(a):'); ?></dt>
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
        <dt class="col-9"><?php echo __('5) Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional:'); ?></dt>
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
        <dt class="col-9"><?php echo __('6) CRITICIDADE E INICATIVA: Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:'); ?></dt>
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
        <dt class="col-9"><?php echo __('7) Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:'); ?></dt>
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
        <dt class="col-9"><?php echo __('8) Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:'); ?></dt>
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
        <dt class="col-9"><?php echo __('9) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?'); ?></dt>
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
        <dt class="col-9"><?php echo __('Fundamente se achar necessário:'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao9_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao9-1'], 'readonly']); ?>
            &nbsp;
        </dd>
        <dt class="col-9"><?php echo __('10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular, pelas condições estabelecidas pelo estágio remoto?'); ?></dt>
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
        <dt class="col-9"><?php echo __('Justifique a resposta se achar necessário:'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao10_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao10-1'], 'readonly']); ?>
            &nbsp;
        </dd>
        <dt class="col-9"><?php echo __('11) Quanto à integração Disciplina de OTP/Coordenação de Estágio da ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a),  professor(a) e supervisor(a)?'); ?></dt>
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
        <dt class="col-9"><?php echo __('Como você avalia esta interação? (Responda se achar necessário)'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao11_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao11-1'], 'readonly']); ?>
            &nbsp;
        </dd>
        <dt class="col-9"><?php echo __('12) Você recebeu e acompanhou o programa da Disciplina OTP?'); ?></dt>
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

            &nbsp;
        </dd>
        <dt class="col-9"><?php echo __('Sugestões ao que foi desenvolvido?'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao12_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao12-1'], 'readonly']); ?>
            &nbsp;
        </dd>
        <dt class="col-9"><?php echo __('13) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?'); ?></dt>
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
        <dt class="col-9"><?php echo __('Se sim, quais?'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao13_1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao13-1'], 'readonly']); ?>
            &nbsp;
        </dd>
        <dt class="col-9"><?php echo __('14) Como avalia a experiência do estágio remoto neste semestre? Será possível a continuidade do estágio na modalidade remota no próximo semestre?'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('avaliacao14', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['avaliacao14'], 'readonly' => 'readonly']); ?>
            &nbsp;
        </dd>
        <dt class="col-9"><?php echo __('Sugestões e observações:'); ?></dt>
        <dd class="col-3">
            <?= $this->Form->input('observacoes', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60, 'value' => $avaliacao['Avaliacao']['observacoes'], 'readonly']); ?>
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