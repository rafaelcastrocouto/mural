<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio $instituicaoestagio
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Instituicaoestagio'), ['action' => 'edit', $instituicaoestagio->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Instituicaoestagio'), ['action' => 'delete', $instituicaoestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instituicaoestagio->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Instituicaoestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Instituicaoestagio'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="instituicaoestagios view content">
            <h3><?= h($instituicaoestagio->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Instituicao') ?></th>
                    <td><?= $instituicaoestagio->instituicao ?></td>
                </tr>
                <tr>
                    <th><?= __('Areainstituicao') ?></th>
                    <td><?= $instituicaoestagio->has('areainstituicao') ? $this->Html->link($instituicaoestagio->areainstituicao->id, ['controller' => 'Areainstituicoes', 'action' => 'view', $instituicaoestagio->areainstituicao->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Natureza') ?></th>
                    <td><?= h($instituicaoestagio->natureza) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cnpj') ?></th>
                    <td><?= h($instituicaoestagio->cnpj) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($instituicaoestagio->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($instituicaoestagio->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereco') ?></th>
                    <td><?= h($instituicaoestagio->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($instituicaoestagio->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Municipio') ?></th>
                    <td><?= h($instituicaoestagio->municipio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cep') ?></th>
                    <td><?= h($instituicaoestagio->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($instituicaoestagio->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fax') ?></th>
                    <td><?= h($instituicaoestagio->fax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Beneficio') ?></th>
                    <td><?= h($instituicaoestagio->beneficio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fim De Semana') ?></th>
                    <td><?= h($instituicaoestagio->fim_de_semana) ?></td>
                </tr>
                <tr>
                    <th><?= __('LocalInscricao') ?></th>
                    <td><?= h($instituicaoestagio->localInscricao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Seguro') ?></th>
                    <td><?= h($instituicaoestagio->seguro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Avaliacao') ?></th>
                    <td><?= h($instituicaoestagio->avaliacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observacoes') ?></th>
                    <td><?= h($instituicaoestagio->observacoes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($instituicaoestagio->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= $this->Number->format($instituicaoestagio->area) ?></td>
                </tr>
                <tr>
                    <th><?= __('Convenio') ?></th>
                    <td><?= $this->Number->format($instituicaoestagio->convenio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Expira') ?></th>
                    <td><?= h($instituicaoestagio->expira) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Supervisores') ?></h4>
                <?php if (!empty($instituicaoestagio->supervisores)) : ?>
                <div class="table-responsive">
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
                            <th><?= __('Area Curso') ?></th>
                            <th><?= __('Ano Curso') ?></th>
                            <th><?= __('Cargo') ?></th>
                            <th><?= __('Num Inscricao') ?></th>
                            <th><?= __('Curso Turma') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($instituicaoestagio->supervisores as $supervisores) : ?>
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
                            <td><?= h($supervisores->email) ?></td>
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
                                <?= $this->Html->link(__('View'), ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Supervisores', 'action' => 'edit', $supervisores->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Supervisores', 'action' => 'delete', $supervisores->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisores->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Estagiarios') ?></h4>
                <?php if (!empty($instituicaoestagio->estagiarios)) : ?>
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
                            <th><?= __('Docente Id') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Areaestagio Id') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('Ch') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($instituicaoestagio->estagiarios as $estagiarios) : ?>
                        <tr>
                            <td><?= h($estagiarios->id) ?></td>
                            <td><?= h($estagiarios->id_aluno) ?></td>
                            <td><?= $estagiarios->has('aluno') ? $this->Html->link($estagiarios->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiarios->alunonovo_id]) : '' ?></td>
                            <td><?= h($estagiarios->registro) ?></td>
                            <td><?= h($estagiarios->ajustecurricular2020) ?></td>
                            <td><?= h($estagiarios->turno) ?></td>
                            <td><?= h($estagiarios->nivel) ?></td>
                            <td><?= h($estagiarios->tc) ?></td>
                            <td><?= h($estagiarios->tc_solicitacao) ?></td>
                            <td><?= $estagiarios->has('instituicaoestagio') ? $this->Html->link($estagiarios->instituicaoestagio->instituicao, ['controller' => 'instituicaoestagios', 'action' => 'view', $estagiarios->id_instituicao]) : '' ?></td>
                            <td><?= $estagiarios->has('supervisor') ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->id_supervisor]) : '' ?></td>
                            <td><?= $estagiarios->has('docente') ? $this->Html->link(h($estagiarios->docente->nome), ['controller' => 'docentes', 'action' => 'view', $estagiarios->id_docente]) : '' ?></td>
                            <td><?= h($estagiarios->periodo) ?></td>
                            <td><?= h($estagiarios->id_area) ?></td>
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
            <div class="related">
                <h4><?= __('Related Muralestagios') ?></h4>
                <?php if (!empty($instituicaoestagio->muralestagios)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Estagio Id') ?></th>
                            <th><?= __('Instituicao') ?></th>
                            <th><?= __('Convenio') ?></th>
                            <th><?= __('Vagas') ?></th>
                            <th><?= __('Beneficios') ?></th>
                            <th><?= __('Final De Semana') ?></th>
                            <th><?= __('CargaHoraria') ?></th>
                            <th><?= __('Requisitos') ?></th>
                            <th><?= __('Areaestagio Id') ?></th>
                            <th><?= __('Horario') ?></th>
                            <th><?= __('Docente Id') ?></th>
                            <th><?= __('DataSelecao') ?></th>
                            <th><?= __('DataInscricao') ?></th>
                            <th><?= __('HorarioSelecao') ?></th>
                            <th><?= __('LocalSelecao') ?></th>
                            <th><?= __('FormaSelecao') ?></th>
                            <th><?= __('Contato') ?></th>
                            <th><?= __('Outras') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Datafax') ?></th>
                            <th><?= __('LocalInscricao') ?></th>
                            <th><?= __('Email') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($instituicaoestagio->muralestagios as $muralestagios) : ?>
                        <tr>
                            <td><?= h($muralestagios->id) ?></td>
                            <td><?= h($muralestagios->id_estagio) ?></td>
                            <td><?= h($muralestagios->instituicao) ?></td>
                            <td><?= h($muralestagios->convenio) ?></td>
                            <td><?= h($muralestagios->vagas) ?></td>
                            <td><?= h($muralestagios->beneficios) ?></td>
                            <td><?= h($muralestagios->final_de_semana) ?></td>
                            <td><?= h($muralestagios->cargaHoraria) ?></td>
                            <td><?= h($muralestagios->requisitos) ?></td>
                            <td><?= h($muralestagios->areaestagio_id) ?></td>
                            <td><?= h($muralestagios->horario) ?></td>
                            <td><?= h($muralestagios->docente_id) ?></td>
                            <td><?= h($muralestagios->dataSelecao) ?></td>
                            <td><?= h($muralestagios->dataInscricao) ?></td>
                            <td><?= h($muralestagios->horarioSelecao) ?></td>
                            <td><?= h($muralestagios->localSelecao) ?></td>
                            <td><?= h($muralestagios->formaSelecao) ?></td>
                            <td><?= h($muralestagios->contato) ?></td>
                            <td><?= h($muralestagios->outras) ?></td>
                            <td><?= h($muralestagios->periodo) ?></td>
                            <td><?= h($muralestagios->datafax) ?></td>
                            <td><?= h($muralestagios->localInscricao) ?></td>
                            <td><?= h($muralestagios->email) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Muralestagios', 'action' => 'edit', $muralestagios->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Muralestagios', 'action' => 'delete', $muralestagios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagios->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Visitas') ?></h4>
                <?php if (!empty($instituicaoestagio->visitas)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituicaoestagio Id') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Motivo') ?></th>
                            <th><?= __('Responsavel') ?></th>
                            <th><?= __('Descricao') ?></th>
                            <th><?= __('Avaliacao') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($instituicaoestagio->visitas as $visitas) : ?>
                        <tr>
                            <td><?= h($visitas->id) ?></td>
                            <td><?= h($visitas->instituicaoestagio_id) ?></td>
                            <td><?= h($visitas->data) ?></td>
                            <td><?= h($visitas->motivo) ?></td>
                            <td><?= h($visitas->responsavel) ?></td>
                            <td><?= h($visitas->descricao) ?></td>
                            <td><?= h($visitas->avaliacao) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Visitas', 'action' => 'view', $visitas->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Visitas', 'action' => 'edit', $visitas->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Visitas', 'action' => 'delete', $visitas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $visitas->id)]) ?>
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
