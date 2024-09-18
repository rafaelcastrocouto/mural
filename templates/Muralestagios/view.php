<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */

//pr($muralestagio);
//die();


?>

<div>
    <div class="column-responsive column-80">
        <div class="muralestagios view content">
		    <aside>
		        <div class="side-nav">
		            <?= $this->Html->link(__('Editar Muralestagio'), ['action' => 'edit', $muralestagio->id], ['class' => 'side-nav-item']) ?>
		            <?= $this->Form->postLink(__('Deletar Muralestagio'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagio->id), 'class' => 'side-nav-item']) ?>
		            <?= $this->Html->link(__('Listar Muralestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
		            <?= $this->Html->link(__('Novo Muralestagio'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
		        </div>
		    </aside>
            <h3>muralestagios_<?= h($muralestagio->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($muralestagio->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituicao') ?></th>
                    <td><?= $muralestagio->instituicao ? $this->Html->link($muralestagio->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $muralestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Vagas') ?></th>
                    <td><?= $this->Number->format($muralestagio->vagas) ?></td>
                </tr>
                <tr>
                    <th><?= __('Convenio') ?></th>
                    <td>
						<?= h($muralestagio->convenio) ? 'Sim' : 'Não'; ?>
					</td>
                </tr>
                <tr>
                    <th><?= __('Beneficios') ?></th>
                    <td><?= h($muralestagio->beneficios) ?></td>
                </tr>
                <tr>
                    <th><?= __('Final De Semana') ?></th>
                    <td>
						<?php
						switch ( h($muralestagio->final_de_semana) ) {
							case 0: $final_de_semana = 'Não';
								break;
							case 1: $final_de_semana = 'Sim';
								break;
							case 2: $final_de_semana = 'Parcialmente';
								break;
						}
						echo $final_de_semana;
						?>
					</td>
                </tr>
                <tr>
                    <th><?= __('Requisitos') ?></th>
                    <td><?= h($muralestagio->requisitos) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area estagio') ?></th>
                    <td><?= $muralestagio->areaestagio ? $this->Html->link($muralestagio->areaestagio->area, ['controller' => 'Areaestagios', 'action' => 'view', $muralestagio->areaestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Turno') ?></th>
                    <td>
					<?php
					switch ( h($muralestagio->turno) ) {
						case 'D': $turno = 'Diurno'; break;
						case 'N': $turno = 'Noturno'; break;
						case 'A': $turno = 'Ambos'; break;
					}
					echo $turno;
					?>
					</td>
                </tr>
                <tr>
                    <th><?= __('Professor') ?></th>
                    <td><?= $muralestagio->professor ? $this->Html->link($muralestagio->professor->nome, ['controller' => 'Professores', 'action' => 'view', $muralestagio->professor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('HorarioSelecao') ?></th>
                    <td><?= h($muralestagio->horarioSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('LocalSelecao') ?></th>
                    <td><?= h($muralestagio->localSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('FormaSelecao') ?></th>
                    <td>
						<?php
						switch ( h($muralestagio->formaSelecao) ) {
							case 0: $formaselecao = 'Entrevista';
								break;
							case 1: $formaselecao = 'CR';
								break;
							case 2: $formaselecao = 'Prova';
								break;
							case 3: $formaselecao = 'Outra';
								break;
						}
						echo $formaselecao;
						?>
					</td>
                </tr>
                <tr>
                    <th><?= __('Contato') ?></th>
                    <td><?= h($muralestagio->contato) ?></td>
                </tr>
                <tr>
                    <th><?= __('Periodo') ?></th>
                    <td><?= h($muralestagio->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('LocalInscricao') ?></th>
                    <td><?= h($muralestagio->localInscricao) ? "Inscrição somente no mural da Coordenação de Estágio da ESS" : "Inscrição no mural da Coordenação de Estágio da ESS e na Instituição" ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($muralestagio->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('CargaHoraria') ?></th>
                    <td><?= $this->Number->format($muralestagio->cargaHoraria) ?></td>
                </tr>
                <tr>
                    <th><?= __('DataSelecao') ?></th>
                    <td><?= h($muralestagio->dataSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('DataInscricao') ?></th>
                    <td><?= h($muralestagio->dataInscricao) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Outras') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($muralestagio->outras)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Inscricoes para o Mural de Estágios') ?></h4>
                <?php if (!empty($muralestagio->inscricoes)) : ?>
                <div>
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Muralestagio Id') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Timestamp') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($muralestagio->inscricoes as $inscricao) : ?>
                        <tr>
                            <?php // pr($inscricao) ?>
                            <td><?= h($inscricao->id) ?></td>
                            <td><?= h($inscricao->aluno_id) ?></td>
                            <td><?= $this->Html->link($inscricao->aluno ? $inscricao->aluno->nome : '-', ['controller' => 'Alunos', 'action' => 'view', $inscricao->alunonovo_id]); ?></td>
                            <td><?= h($inscricao->instituicao_id) ?></td>
                            <td><?= h($inscricao->data) ?></td>
                            <td><?= h($inscricao->periodo) ?></td>
                            <td><?= h($inscricao->timestamp) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscricao->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscricao->id)]) ?>
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
