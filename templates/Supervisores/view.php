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
                <h4><?= __('Related Instituicaoestagios') ?></h4>
                <?php if (!empty($supervisor->instituicaoestagios)) : ?>
                    <div class="table-responsive">
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
                                <th><?= __('Fax') ?></th>
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
                            <?php foreach ($supervisor->instituicaoestagios as $instituicaoestagios) : ?>
                                <tr>
                                    <td><?= h($instituicaoestagios->id) ?></td>
                                    <td><?= h($instituicaoestagios->instituicao) ?></td>
                                    <td><?= $instituicaoestagios->has('areainstituicao') ? $this->Html->link(h($instituicaoestagios->areainstituicao->area), ['controller' => 'areainstituicoes', 'action' => 'view', $instituicaoestagios->area_instituicoes_id]) : '' ?></td>
                                    <td><?= h($instituicaoestagios->area) ?></td>
                                    <td><?= h($instituicaoestagios->natureza) ?></td>
                                    <td><?= h($instituicaoestagios->cnpj) ?></td>
                                    <td><?= h($instituicaoestagios->email) ?></td>
                                    <td><?= h($instituicaoestagios->url) ?></td>
                                    <td><?= h($instituicaoestagios->endereco) ?></td>
                                    <td><?= h($instituicaoestagios->bairro) ?></td>
                                    <td><?= h($instituicaoestagios->municipio) ?></td>
                                    <td><?= h($instituicaoestagios->cep) ?></td>
                                    <td><?= h($instituicaoestagios->telefone) ?></td>
                                    <td><?= h($instituicaoestagios->fax) ?></td>
                                    <td><?= h($instituicaoestagios->beneficio) ?></td>
                                    <td><?= h($instituicaoestagios->fim_de_semana) ?></td>
                                    <td><?= h($instituicaoestagios->localInscricao) ?></td>
                                    <td><?= h($instituicaoestagios->convenio) ?></td>
                                    <td><?= h($instituicaoestagios->expira) ?></td>
                                    <td><?= h($instituicaoestagios->seguro) ?></td>
                                    <td><?= h($instituicaoestagios->avaliacao) ?></td>
                                    <td><?= h($instituicaoestagios->observacoes) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Instituicaoestagios', 'action' => 'view', $instituicaoestagios->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Instituicaoestagios', 'action' => 'edit', $instituicaoestagios->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Instituicaoestagios', 'action' => 'delete', $instituicaoestagios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instituicaoestagios->id)]) ?>
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
                    <div class="table-responsive">
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
                                <th><?= __('Instituicaoestagio Id') ?></th>
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
                                    <td><?= $estagiarios->has('instituicaoestagio') ? $this->Html->link(h($estagiarios->instituicaoestagio->instituicao), ['controller' => 'instituicaoestagios', 'action' => 'view', $estagiarios->id_instituicao]) : '' ?></td>
                                    <td><?= $estagiarios->has('supervisor') ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?></td>
                                    <td><?= $estagiarios->has('professor') ? $this->Html->link(h($estagiarios->professor->nome), ['controller' => 'professores', 'action' => 'view', $estagiarios->id_professor]) : '' ?></td>
                                    <td><?= h($estagiarios->periodo) ?></td>
                                    <td><?= h($estagiarios->areaestagio_id) ?></td>
                                    <td><?= h($estagiarios->nota) ?></td>
                                    <td><?= h($estagiarios->ch) ?></td>
                                    <td><?= h($estagiarios->observacoes) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
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
