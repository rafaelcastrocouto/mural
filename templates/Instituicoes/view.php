<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao $instituicao
 */
//pr($instituicao);
//die();
?>
<div>
    <div class="column-responsive column-80">
        <div class="instituicoes view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Editar Instituição'), ['action' => 'edit', $instituicao->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Instituição'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Are you sure you want to delete {0}?', $instituicao->instituicao), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Listar Instituições'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Nova Instituição'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>instituicao_<?= h($instituicao->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $instituicao->id ? $this->Number->format($instituicao->id) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituicao') ?></th>
                    <td><?= $instituicao->instituicao ?></td>
                </tr>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= $instituicao->area ? $this->Html->link(''.$instituicao->area->area, ['controller' => 'Areas', 'action' => 'view', $instituicao->area->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Natureza') ?></th>
                    <td><?= h($instituicao->natureza) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cnpj') ?></th>
                    <td><?= h($instituicao->cnpj) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= $instituicao->email ? $this->Text->autoLinkEmails($instituicao->email) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($instituicao->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereco') ?></th>
                    <td><?= h($instituicao->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($instituicao->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Municipio') ?></th>
                    <td><?= h($instituicao->municipio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cep') ?></th>
                    <td><?= h($instituicao->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($instituicao->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Beneficio') ?></th>
                    <td><?= h($instituicao->beneficio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fim De Semana') ?></th>
                    <td><?= h($instituicao->fim_de_semana) ?></td>
                </tr>
                <tr>
                    <th><?= __('LocalInscricao') ?></th>
                    <td><?= h($instituicao->localInscricao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Seguro') ?></th>
                    <td><?= h($instituicao->seguro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Avaliacao') ?></th>
                    <td><?= h($instituicao->avaliacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observacoes') ?></th>
                    <td><?= h($instituicao->observacoes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Convenio') ?></th>
                    <td><?= $instituicao->convenio ? $this->Number->format($instituicao->convenio) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Expira') ?></th>
                    <td><?= h($instituicao->expira) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Supervisores') ?></h4>
                <?php if (!empty($instituicao->supervisores)) : ?>
                <div>
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nome') ?></th>
                            <th><?= __('Cpf') ?></th>
                            <th><?= __('Endereco') ?></th>
                            <th><?= __('Bairro') ?></th>
                            <th><?= __('Municipio') ?></th>
                            <th><?= __('Cep') ?></th>
                            <th><?= __('Codigo Tel') ?></th>
                            <th><?= __('Telefone') ?></th>
                            <th><?= __('Codigo Cel') ?></th>
                            <th><?= __('Celular') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Escola') ?></th>
                            <th><?= __('Ano Formatura') ?></th>
                            <th><?= __('Cress') ?></th>
                            <th><?= __('Regiao') ?></th>
                            <th><?= __('Outros Estudos') ?></th>
                            <th><?= __('Ano Curso') ?></th>
                            <th><?= __('Cargo') ?></th>
                            <th><?= __('Num Inscricao') ?></th>
                            <th><?= __('Curso Turma') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($instituicao->supervisores as $supervisores) : ?>
                        <tr>
                            <td><?= h($supervisores->id) ?></td>
                            <td><?= $this->Html->link($supervisores->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id]) ?></td>
                            <td><?= h($supervisores->cpf) ?></td>
                            <td><?= h($supervisores->endereco) ?></td>
                            <td><?= h($supervisores->bairro) ?></td>
                            <td><?= h($supervisores->municipio) ?></td>
                            <td><?= h($supervisores->cep) ?></td>
                            <td><?= h($supervisores->codigo_tel) ?></td>
                            <td><?= h($supervisores->telefone) ?></td>
                            <td><?= h($supervisores->codigo_cel) ?></td>
                            <td><?= h($supervisores->celular) ?></td>
                            <td><?= $supervisores->email ? $this->Text->autoLinkEmails($supervisores->email) : '' ?></td>
                            <td><?= h($supervisores->escola) ?></td>
                            <td><?= h($supervisores->ano_formatura) ?></td>
                            <td><?= h($supervisores->cress) ?></td>
                            <td><?= h($supervisores->regiao) ?></td>
                            <td><?= h($supervisores->outros_estudos) ?></td>
                            <td><?= h($supervisores->area_curso) ?></td>
                            <td><?= h($supervisores->ano_curso) ?></td>
                            <td><?= h($supervisores->cargo) ?></td>
                            <td><?= h($supervisores->num_inscricao) ?></td>
                            <td><?= h($supervisores->curso_turma) ?></td>
                            <td><?= h($supervisores->observacoes) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Supervisores', 'action' => 'edit', $supervisores->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Supervisores', 'action' => 'delete', $supervisores->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisores->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Estagiarios') ?></h4>
                <?php if (!empty($instituicao->estagiarios)) : ?>
                <div>
                    <table>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Nome') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Ajustecurricular2020') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Tc') ?></th>
                            <th><?= __('Tc Solicitacao') ?></th>
                            <th><?= __('Instituicao') ?></th>
                            <th><?= __('Supervisor') ?></th>
                            <th><?= __('Professor') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Area estagio') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('Ch') ?></th>
                            <th><?= __('Observacoes') ?></th>
                        </tr>
                        <?php foreach ($instituicao->estagiarios as $estagiario) : ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiario->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiario->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id)]) ?>
                            </td>
                            <td><?= h($estagiario->id) ?></td>
                            <td><?= h($estagiario->aluno_id) ?></td>
                            <td><?= $estagiario->aluno ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?></td>
                            <td><?= h($estagiario->registro) ?></td>
                            <td><?= h($estagiario->ajustecurricular2020) ?></td>
                            <td><?= h($estagiario->turno) ?></td>
                            <td><?= h($estagiario->nivel) ?></td>
                            <td><?= h($estagiario->tc) ?></td>
                            <td><?= h($estagiario->tc_solicitacao) ?></td>
                            <td><?= $estagiario->instituicao ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?></td>
                            <td><?= $estagiario->supervisor ? $this->Html->link(h($estagiario->supervisor->nome), ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?></td>
                            <td><?= $estagiario->professor ? $this->Html->link(h($estagiario->professor->nome), ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?></td>
                            <td><?= h($estagiario->periodo) ?></td>
                            <td><?= $estagiario->turmaestagio ? $this->Html->link($estagiario->turmaestagio->turma, ['controller' => 'Turmaestagios', 'action' => 'view', $estagiario->turmaestagio->id]) : '' ?></td>
                            <td><?= h($estagiario->nota) ?></td>
                            <td><?= h($estagiario->ch) ?></td>
                            <td><?= h($estagiario->observacoes) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Muralestagios') ?></h4>
                <?php if (!empty($instituicao->muralestagios)) : ?>
                <div>
                    <table>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituicao') ?></th>
                            <th><?= __('Convenio') ?></th>
                            <th><?= __('Vagas') ?></th>
                            <th><?= __('Beneficios') ?></th>
                            <th><?= __('Final De Semana') ?></th>
                            <th><?= __('CargaHoraria') ?></th>
                            <th><?= __('Turma') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Professor') ?></th>
                            <th><?= __('DataSelecao') ?></th>
                            <th><?= __('DataInscricao') ?></th>
                            <th><?= __('HorarioSelecao') ?></th>
                            <th><?= __('LocalSelecao') ?></th>
                            <th><?= __('FormaSelecao') ?></th>
                            <th><?= __('Contato') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('LocalInscricao') ?></th>
                            <th><?= __('Email') ?></th>
                        </tr>
                        <?php foreach ($instituicao->muralestagios as $muralestagios) : ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Muralestagios', 'action' => 'edit', $muralestagios->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Muralestagios', 'action' => 'delete', $muralestagios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagios->id)]) ?>
                            </td>
                            <td><?= h($muralestagios->id) ?></td>
                            <td><?= h($muralestagios->instituicao) ?></td>
                            <td><?= h($muralestagios->convenio) ?></td>
                            <td><?= h($muralestagios->vagas) ?></td>
                            <td><?= h($muralestagios->beneficios) ?></td>
                            <td><?= h($muralestagios->final_de_semana) ?></td>
                            <td><?= h($muralestagios->cargaHoraria) ?></td>
                            <td><?= h($muralestagios->turmaestagio_id) ?></td>
                            <td><?= h($muralestagios->turno) ?></td>
                            <td><?= h($muralestagios->professor_id) ?></td>
                            <td><?= h($muralestagios->dataSelecao) ?></td>
                            <td><?= h($muralestagios->dataInscricao) ?></td>
                            <td><?= h($muralestagios->horarioSelecao) ?></td>
                            <td><?= h($muralestagios->localSelecao) ?></td>
                            <td><?= h($muralestagios->formaSelecao) ?></td>
                            <td><?= h($muralestagios->contato) ?></td>
                            <td><?= h($muralestagios->periodo) ?></td>
                            <td><?= h($muralestagios->localInscricao) ?></td>
                            <td><?= $muralestagios->email ? $this->Text->autoLinkEmails($muralestagios->email) : '' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Visitas') ?></h4>
                <?php if (!empty($instituicao->visitas)) : ?>
                <div>
                    <table>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituicao Id') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Motivo') ?></th>
                            <th><?= __('Responsavel') ?></th>
                            <th><?= __('Descricao') ?></th>
                            <th><?= __('Avaliacao') ?></th>
                        </tr>
                        <?php foreach ($instituicao->visitas as $visitas) : ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Visitas', 'action' => 'view', $visitas->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Visitas', 'action' => 'edit', $visitas->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Visitas', 'action' => 'delete', $visitas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $visitas->id)]) ?>
                            </td>
                            <td><?= h($visitas->id) ?></td>
                            <td><?= h($visitas->instituicao_id) ?></td>
                            <td><?= h($visitas->data) ?></td>
                            <td><?= h($visitas->motivo) ?></td>
                            <td><?= h($visitas->responsavel) ?></td>
                            <td><?= h($visitas->descricao) ?></td>
                            <td><?= h($visitas->avaliacao) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
