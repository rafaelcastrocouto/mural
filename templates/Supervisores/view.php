<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Supervisor'), ['action' => 'edit', $supervisor->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Supervisor'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisor->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Supervisores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Supervisor'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="supervisores view content">
            <h3><?= h($supervisor->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($supervisor->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpf') ?></th>
                    <td><?= h($supervisor->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereco') ?></th>
                    <td><?= h($supervisor->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($supervisor->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Municipio') ?></th>
                    <td><?= h($supervisor->municipio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cep') ?></th>
                    <td><?= h($supervisor->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Codigo Tel') ?></th>
                    <td><?= h($supervisor->codigo_tel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($supervisor->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Codigo Cel') ?></th>
                    <td><?= h($supervisor->codigo_cel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= h($supervisor->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($supervisor->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Escola') ?></th>
                    <td><?= h($supervisor->escola) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ano Formatura') ?></th>
                    <td><?= h($supervisor->ano_formatura) ?></td>
                </tr>
                <tr>
                    <th><?= __('Outros Estudos') ?></th>
                    <td><?= h($supervisor->outros_estudos) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area Curso') ?></th>
                    <td><?= h($supervisor->area_curso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ano Curso') ?></th>
                    <td><?= h($supervisor->ano_curso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cargo') ?></th>
                    <td><?= h($supervisor->cargo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curso Turma') ?></th>
                    <td><?= h($supervisor->curso_turma) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($supervisor->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cress') ?></th>
                    <td><?= $this->Number->format($supervisor->cress) ?></td>
                </tr>
                <tr>
                    <th><?= __('Regiao') ?></th>
                    <td><?= $this->Number->format($supervisor->regiao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Num Inscricao') ?></th>
                    <td><?= $this->Number->format($supervisor->num_inscricao) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Observacoes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($supervisor->observacoes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Instituicoes') ?></h4>
                <?php if (!empty($supervisor->instituicoes)) : ?>
                    <div>
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Instituicao') ?></th>
                                <th><?= __('Areainstituicoes Id') ?></th>
                                <th><?= __('Area') ?></th>
                                <th><?= __('Natureza') ?></th>
                                <th><?= __('Cnpj') ?></th>
                                <th><?= __('Email') ?></th>
                                <th><?= __('Url') ?></th>
                                <th><?= __('Endereco') ?></th>
                                <th><?= __('Bairro') ?></th>
                                <th><?= __('Municipio') ?></th>
                                <th><?= __('Cep') ?></th>
                                <th><?= __('Telefone') ?></th>
                                <th><?= __('Beneficio') ?></th>
                                <th><?= __('Fim De Semana') ?></th>
                                <th><?= __('LocalInscricao') ?></th>
                                <th><?= __('Convenio') ?></th>
                                <th><?= __('Expira') ?></th>
                                <th><?= __('Seguro') ?></th>
                                <th><?= __('Avaliacao') ?></th>
                                <th><?= __('Observacoes') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($supervisor->instituicoes as $instituicao) : ?>
                                <tr>
                                    <td><?= h($instituicao->id) ?></td>
                                    <td><?= h($instituicao->instituicao) ?></td>
                                    <td><?= $instituicao->areainstituicao ? $this->Html->link(h($instituicao->areainstituicao->area), ['controller' => 'areainstituicoes', 'action' => 'view', $instituicao->area_instituicoes_id]) : '' ?></td>
                                    <td><?= h($instituicao->area) ?></td>
                                    <td><?= h($instituicao->natureza) ?></td>
                                    <td><?= h($instituicao->cnpj) ?></td>
                                    <td><?= h($instituicao->email) ?></td>
                                    <td><?= h($instituicao->url) ?></td>
                                    <td><?= h($instituicao->endereco) ?></td>
                                    <td><?= h($instituicao->bairro) ?></td>
                                    <td><?= h($instituicao->municipio) ?></td>
                                    <td><?= h($instituicao->cep) ?></td>
                                    <td><?= h($instituicao->telefone) ?></td>
                                    <td><?= h($instituicao->beneficio) ?></td>
                                    <td><?= h($instituicao->fim_de_semana) ?></td>
                                    <td><?= h($instituicao->localInscricao) ?></td>
                                    <td><?= h($instituicao->convenio) ?></td>
                                    <td><?= h($instituicao->expira) ?></td>
                                    <td><?= h($instituicao->seguro) ?></td>
                                    <td><?= h($instituicao->avaliacao) ?></td>
                                    <td><?= h($instituicao->observacoes) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Instituicoes', 'action' => 'view', $instituicao->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Instituicoes', 'action' => 'edit', $instituicao->id]) ?>
                                        <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Instituicoes', 'action' => 'delete', $instituicao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instituicao->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Estagiarios') ?></h4>
                <?php if (!empty($supervisor->estagiarios)) : ?>
                    <div>
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Aluno Id') ?></th>
                                <th><?= __('Registro') ?></th>
                                <th><?= __('Ajustecurricular2020') ?></th>
                                <th><?= __('Turno') ?></th>
                                <th><?= __('Nivel') ?></th>
                                <th><?= __('Tc') ?></th>
                                <th><?= __('Tc Solicitacao') ?></th>
                                <th><?= __('Instituicao Id') ?></th>
                                <th><?= __('Supervisor Id') ?></th>
                                <th><?= __('Professor Id') ?></th>
                                <th><?= __('Periodo') ?></th>
                                <th><?= __('Areaestagio Id') ?></th>
                                <th><?= __('Nota') ?></th>
                                <th><?= __('Ch') ?></th>
                                <th><?= __('Observacoes') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($supervisor->estagiarios as $estagiarios) : ?>
                                <tr>
                                    <td><?= h($estagiarios->id) ?></td>
                                    <td><?= h($estagiarios->aluno_id) ?></td>
                                    <td><?= $this->Html->link($estagiarios->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiarios->alunonovo_id]) ?></td>
                                    <td><?= h($estagiarios->registro) ?></td>
                                    <td><?= h($estagiarios->ajustecurricular2020) ?></td>
                                    <td><?= h($estagiarios->turno) ?></td>
                                    <td><?= h($estagiarios->nivel) ?></td>
                                    <td><?= h($estagiarios->tc) ?></td>
                                    <td><?= h($estagiarios->tc_solicitacao) ?></td>
                                    <td><?= $estagiarios->instituicao ? $this->Html->link(h($estagiarios->instituicao->instituicao), ['controller' => 'instituicoes', 'action' => 'view', $estagiarios->instituicao->id]) : '' ?></td>
                                    <td><?= $estagiarios->supervisor ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor->id]) : '' ?></td>
                                    <td><?= $estagiarios->professor ? $this->Html->link(h($estagiarios->professor->nome), ['controller' => 'professores', 'action' => 'view', $estagiarios->professor->id]) : '' ?></td>
                                    <td><?= h($estagiarios->periodo) ?></td>
                                    <td><?= h($estagiarios->areaestagio_id) ?></td>
                                    <td><?= h($estagiarios->nota) ?></td>
                                    <td><?= h($estagiarios->ch) ?></td>
                                    <td><?= h($estagiarios->observacoes) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                        <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>            
    </div>
</div>
</div>
