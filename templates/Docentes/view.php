<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente $docente
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Docente'), ['action' => 'edit', $docente->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Docente'), ['action' => 'delete', $docente->id], ['confirm' => __('Are you sure you want to delete # {0}?', $docente->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Docentes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Docente'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="docentes view content">
            <h3><?= h($docente->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($docente->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpf') ?></th>
                    <td><?= h($docente->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Localnascimento') ?></th>
                    <td><?= h($docente->localnascimento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sexo') ?></th>
                    <td><?= h($docente->sexo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ddd Telefone') ?></th>
                    <td><?= h($docente->ddd_telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($docente->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ddd Celular') ?></th>
                    <td><?= h($docente->ddd_celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= h($docente->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($docente->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Homepage') ?></th>
                    <td><?= h($docente->homepage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Redesocial') ?></th>
                    <td><?= h($docente->redesocial) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curriculolattes') ?></th>
                    <td><?= h($docente->curriculolattes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curriculosigma') ?></th>
                    <td><?= h($docente->curriculosigma) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pesquisadordgp') ?></th>
                    <td><?= h($docente->pesquisadordgp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Formacaoprofissional') ?></th>
                    <td><?= h($docente->formacaoprofissional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Universidadedegraduacao') ?></th>
                    <td><?= h($docente->universidadedegraduacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestradoarea') ?></th>
                    <td><?= h($docente->mestradoarea) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestradouniversidade') ?></th>
                    <td><?= h($docente->mestradouniversidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutoradoarea') ?></th>
                    <td><?= h($docente->doutoradoarea) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutoradouniversidade') ?></th>
                    <td><?= h($docente->doutoradouniversidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Formaingresso') ?></th>
                    <td><?= h($docente->formaingresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipocargo') ?></th>
                    <td><?= h($docente->tipocargo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Categoria') ?></th>
                    <td><?= h($docente->categoria) ?></td>
                </tr>
                <tr>
                    <th><?= __('Regimetrabalho') ?></th>
                    <td><?= h($docente->regimetrabalho) ?></td>
                </tr>
                <tr>
                    <th><?= __('Departamento') ?></th>
                    <td><?= h($docente->departamento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Motivoegresso') ?></th>
                    <td><?= h($docente->motivoegresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($docente->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Siape') ?></th>
                    <td><?= $this->Number->format($docente->siape) ?></td>
                </tr>
                <tr>
                    <th><?= __('Anoformacao') ?></th>
                    <td><?= $this->Number->format($docente->anoformacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestradoanoconclusao') ?></th>
                    <td><?= $this->Number->format($docente->mestradoanoconclusao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutoradoanoconclusao') ?></th>
                    <td><?= $this->Number->format($docente->doutoradoanoconclusao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Datanascimento') ?></th>
                    <td><?= h($docente->datanascimento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Atualizacaolattes') ?></th>
                    <td><?= h($docente->atualizacaolattes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dataingresso') ?></th>
                    <td><?= h($docente->dataingresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dataegresso') ?></th>
                    <td><?= h($docente->dataegresso) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Observacoes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($docente->observacoes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Estagiarios') ?></h4>
                <?php if (!empty($docente->estagiarios)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Estudante Id') ?></th>
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
                        <?php foreach ($docente->estagiarios as $estagiarios) : ?>
                        <tr>
                            <td><?= h($estagiarios->id) ?></td>
                            <td><?= h($estagiarios->aluno_id) ?></td>
                            <td><?= h($estagiarios->estudante_id) ?></td>
                            <td><?= h($estagiarios->registro) ?></td>
                            <td><?= h($estagiarios->ajustecurricular2020) ?></td>
                            <td><?= h($estagiarios->turno) ?></td>
                            <td><?= h($estagiarios->nivel) ?></td>
                            <td><?= h($estagiarios->tc) ?></td>
                            <td><?= h($estagiarios->tc_solicitacao) ?></td>
                            <td><?= h($estagiarios->instituicaoestagio_id) ?></td>
                            <td><?= h($estagiarios->supervisor_id) ?></td>
                            <td><?= h($estagiarios->docente_id) ?></td>
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
            <div class="related">
                <h4><?= __('Related Muralestagios') ?></h4>
                <?php if (!empty($docente->muralestagios)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituicaoestagio Id') ?></th>
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
                        <?php foreach ($docente->muralestagios as $muralestagios) : ?>
                        <tr>
                            <td><?= h($muralestagios->id) ?></td>
                            <td><?= h($muralestagios->instituicaoestagio_id) ?></td>
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
                <h4><?= __('Related Userestagios') ?></h4>
                <?php if (!empty($docente->userestagios)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Categoria') ?></th>
                            <th><?= __('Numero') ?></th>
                            <th><?= __('Estudante Id') ?></th>
                            <th><?= __('Supervisor Id') ?></th>
                            <th><?= __('Docente Id') ?></th>
                            <th><?= __('Timestamp') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($docente->userestagios as $userestagios) : ?>
                        <tr>
                            <td><?= h($userestagios->id) ?></td>
                            <td><?= h($userestagios->email) ?></td>
                            <td><?= h($userestagios->password) ?></td>
                            <td><?= h($userestagios->categoria) ?></td>
                            <td><?= h($userestagios->numero) ?></td>
                            <td><?= h($userestagios->estudante_id) ?></td>
                            <td><?= h($userestagios->supervisor_id) ?></td>
                            <td><?= h($userestagios->docente_id) ?></td>
                            <td><?= h($userestagios->timestamp) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Userestagios', 'action' => 'view', $userestagios->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Userestagios', 'action' => 'edit', $userestagios->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Userestagios', 'action' => 'delete', $userestagios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userestagios->id)]) ?>
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
