<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="supervisores view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Supervisores'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Editar Supervisor'), ['action' => 'edit', $supervisor->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Supervisor'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Are you sure you want to delete {0}?', $supervisor->nome), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Novo Supervisor'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>supervisor_<?= h($supervisor->id) ?></h3>
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
                    <td><?= $supervisor->email ? $this->Text->autoLinkEmails($supervisor->email) : '' ?></td>
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
                    <td><?= $supervisor->num_inscrica ? $this->Number->format($supervisor->num_inscricao) : '' ?></td>
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
                                    <td><?= $instituicao->area ? $this->Html->link(h($instituicao->area->area), ['controller' => 'areas', 'action' => 'view', $instituicao->area->id]) : '' ?></td>
                                    <td><?= h($instituicao->natureza) ?></td>
                                    <td><?= h($instituicao->cnpj) ?></td>
                                    <td><?= $this->Text->autoLinkEmails($instituicao->email) ?></td>
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
                                <th><?= __('Turma') ?></th>
                                <th><?= __('Nota') ?></th>
                                <th><?= __('Ch') ?></th>
                                <th><?= __('Observacoes') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($supervisor->estagiarios as $estagiario) : ?>
                                <tr>
                                    <td><?= h($estagiario->id) ?></td>
                                    <td><?= h($estagiario->aluno_id) ?></td>
                                    <td><?= $estagiario->aluno ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?></td>
                                    <td><?= h($estagiario->registro) ?></td>
                                    <td><?= h($estagiario->ajustecurricular2020) ?></td>
                                    <td><?= h($estagiario->turno) ?></td>
                                    <td><?= h($estagiario->nivel) ?></td>
                                    <td><?= h($estagiario->tc) ?></td>
                                    <td><?= h($estagiario->tc_solicitacao) ?></td>
                                    <td><?= $estagiario->instituicao ? $this->Html->link(h($estagiario->instituicao->instituicao), ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?></td>
                                    <td><?= $estagiario->supervisor ? $this->Html->link(h($estagiario->supervisor->nome), ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?></td>
                                    <td><?= $estagiario->professor ? $this->Html->link(h($estagiario->professor->nome), ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?></td>
                                    <td><?= h($estagiario->periodo) ?></td>
                                    <td><?= h($estagiario->turmaestagio_id) ?></td>
                                    <td><?= h($estagiario->nota) ?></td>
                                    <td><?= h($estagiario->ch) ?></td>
                                    <td><?= h($estagiario->observacoes) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiario->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiario->id]) ?>
                                        <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id)]) ?>
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
