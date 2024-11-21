<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao $avaliacao
 */


declare(strict_types=1);

$categoria_id = 0;
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $categoria_id = $user_session->get('categoria_id'); }

// pr($avaliacao);

$supervisora = isset($avaliacao->estagiario->supervisor->nome);
if ($supervisora) {
    $supervisora = $avaliacao->estagiario->supervisor->nome;
} else {
    $supervisora = "____________________";
}

$regiao = isset($avaliacao->estagiario->supervisor->regiao);
if ($regiao) {
    $regiao = $avaliacao->estagiario->supervisor->regiao;
} else {
    $regiao = '__';
}

$cress = isset($avaliacao->estagiario->supervisor->cress);
if ($cress) {
    $cress = $avaliacao->estagiario->supervisor->cress;
} else {
    $cress = '_____';
}

$professora = isset($avaliacao->estagiario->professor->nome);
if ($professora) {
    $professora = $avaliacao->estagiario->professor->nome;
} else {
    $professora = '____________________';
}
?>
<div>
    <div class="column-responsive column-80">
        <div class="areas view content">
            <aside>
                <div class="nav">
                    <?php if ($categoria_id == 1): ?>
                        <?= $this->Html->link(__('Editar avaliação'), ['action' => 'edit', $avaliacao->id], ['class' => 'button']) ?>
                        <?= $this->Form->postLink(__('Excluir avaliação'), ['action' => 'delete', $avaliacao->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $avaliacao->id), 'class' => 'button']) ?>
                        <?= $this->Html->link(__('Listar avaliações'), ['action' => 'index'], ['class' => 'button']) ?>
                        <?= $this->Html->link(__('Nova avaliação'), ['action' => 'add'], ['class' => 'button']) ?>
                    <?php endif; ?>
                    <?= $this->Html->link(__('Imprimir avaliação'), ['action' => 'imprimeavaliacaopdf/' . $avaliacao->id], ['class' => 'button']) ?>
                </div>
            </aside>
            <div class="table_wrap">
                <h3><?= h('avaliacao_' . $avaliacao->id) ?></h3>
                <p>Avaliação da(o) estagiario(a): <?= $avaliacao->hasValue('estagiario') ? $this->Html->link($avaliacao->estagiario->aluno->nome, ['controller' => 'Estagiarios', 'action' => 'view', $avaliacao->estagiario->id]) : '' ?></p>
                <p>Campo de estágio: <?= $avaliacao->estagiario->instituicao->instituicao ?>.</p> 
                <p>Supervisor(a): <?= $supervisora ?>.</p>
                <p>Cress: <?= $cress ?>.</p>
                <p>Período de estágio: <?= $avaliacao->estagiario->periodo ?>. </p>
                <p>Nível: <?= $avaliacao->estagiario->nivel ?>.</p>
                <p>Supervisão acadêmica: <?= $professora ?>.</p>
                <table>
                    <tr>
                        <th><?= __('1) ASSIDUIDADE: Desenvolveu as atividades propostas com frequência, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras:') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao1):
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
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('2) PONTUALIDADE: cumpre horário estabelecido no Plano de Estágio:') ?></th>
                        <td><?php
                        switch ($avaliacao->avaliacao2):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('3) COMPROMISSO: com as ações e estratégias previstas no Plano de Estágio:') ?></th>
                        <td><?php
                        switch ($avaliacao->avaliacao3):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('4) Na relação com o(a) usuário(a): compromisso ético-político no atendimento ao usuário(a):') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao4):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('5) Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional:') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao5):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('6) CRITICIDADE E INICATIVA: Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao6):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('7) Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao7):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('8) Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao8):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('9) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao9):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Fundamente se achar necessário:') ?></th>
                        <td><?= h($avaliacao->avaliacao9_1) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular, pelas condições estabelecidas pelo estágio remoto?') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao10):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Justifique a resposta se achar necessário:') ?></th>
                        <td><?= h($avaliacao->avaliacao10_1) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('11) Quanto à integração Disciplina de OTP/Coordenação de Estágio da ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a),  professor(a) e supervisor(a)?') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao11):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Como você avalia esta interação? (Responda se achar necessário)') ?></th>
                        <td><?= h($avaliacao->avaliacao11_1) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('12) Você recebeu e acompanhou o programa da Disciplina OTP?') ?></th>
                        <td><?php
                        switch ($avaliacao->avaliacao12):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Sugestões ao que foi desenvolvido?') ?></th>
                        <td><?php h($avaliacao->avaliacao12_1) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('13) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?') ?>
                        </th>
                        <td><?php
                        switch ($avaliacao->avaliacao13):
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
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Se sim, quais?') ?></th>
                        <td><?= h($avaliacao->avaliacao13_1) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('14) Como avalia a experiência do estágio remoto neste semestre? Será possível a continuidade do estágio na modalidade remota no próximo semestre?') ?>
                        </th>
                        <td><?= h($avaliacao->avaliacao14) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Sugestões e observações:') ?></th>
                        <td><?= h($avaliacao->observacoes) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>