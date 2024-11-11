<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */


declare(strict_types=1);

$categoria_id = 0;
$session = $this->request->getAttribute('identity');

if ($session) { $categoria_id = $session->get('categoria_id'); }
	
?>

<div>
    <div class="column-responsive column-80">
        <div class="muralestagios view content">
		    <aside>
		        <div class="nav">
					<?= $this->Html->link(__('Listar Muralestagios'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?php if ($categoria_id == 1): ?>
			            <?= $this->Html->link(__('Editar Muralestagio'), ['action' => 'edit', $muralestagio->id], ['class' => 'button']) ?>
			            <?= $this->Form->postLink(__('Deletar Muralestagio'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagio->id), 'class' => 'button']) ?>
			            <?= $this->Html->link(__('Novo Muralestagio'), ['action' => 'add'], ['class' => 'button']) ?>
					<?php endif; ?>
		        </div>
		    </aside>
            <h3>estagio_<?= h($muralestagio->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($muralestagio->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituicao') ?></th>
                    <td><?= $muralestagio->instituicao ? $this->Html->link($muralestagio->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $muralestagio->instituicao->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Convenio') ?></th>
                    <td>
						<?= $muralestagio->convenio ? 'Sim' : 'Não'; ?>
					</td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= $muralestagio->email ? $this->Text->autoLinkEmails($muralestagio->email) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Vagas') ?></th>
                    <td><?= $this->Number->format($muralestagio->vagas) ?></td>
                </tr>
                <tr>
                    <th><?= __('Beneficios') ?></th>
                    <td><?= h($muralestagio->beneficios) ?></td>
                </tr>
                <tr>
                    <th><?= __('Final De Semana') ?></th>
                    <td>
						<?php
						$fim_de_semana = '';
						switch ( $muralestagio->fim_de_semana ) {
							case 0: $fim_de_semana = 'Não';          break;
							case 1: $fim_de_semana = 'Sim';          break;
							case 2: $fim_de_semana = 'Parcialmente'; break;
						}
						echo $fim_de_semana;
						?>
					</td>
                </tr>
                <tr>
                    <th><?= __('Carga Horaria') ?></th>
                    <td><?= $this->Number->format($muralestagio->carga_horaria) ?></td>
                </tr>
                <tr>
                    <th><?= __('Requisitos') ?></th>
                    <td><?= $muralestagio->requisitos ?></td>
                </tr>
                <tr>
                    <th><?= __('Turma') ?></th>
                    <td><?= $muralestagio->turmaestagio ? $this->Html->link($muralestagio->turmaestagio->turma, ['controller' => 'Turmaestagios', 'action' => 'view', $muralestagio->turmaestagio->id]) : $muralestagio->turma_estagio_id ?></td>
                </tr>
                <tr>
                    <th><?= __('Turno') ?></th>
                    <td>
						<?php
						$turno = '';
						switch ( $muralestagio->turno ) {
							case 'D': $turno = 'Diurno';   break;
							case 'N': $turno = 'Noturno';  break;
							case 'A': $turno = 'Ambos';    break;
		                    case 'I': $turno = 'Integral'; break;
						}
						echo h($turno);
						?>
					</td>
                </tr>
                <tr>
                    <th><?= __('Professor') ?></th>
                    <td><?= $muralestagio->professor ? $this->Html->link($muralestagio->professor->nome, ['controller' => 'Professores', 'action' => 'view', $muralestagio->professor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Local Inscricao') ?></th>
                    <td><?= h($muralestagio->local_inscricao) ? "Inscrição somente no mural da Coordenação de Estágio da ESS" : "Inscrição na Instituição e no mural da Coordenação de Estágio da ESS" ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Inscricao') ?></th>
                    <td><?= h($muralestagio->data_inscricao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Local Selecao') ?></th>
                    <td><?= h($muralestagio->local_selecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Selecao') ?></th>
                    <td><?= h($muralestagio->data_selecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Horario Selecao') ?></th>
                    <td><?= h($muralestagio->horario_selecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Forma Selecao') ?></th>
                    <td>
						<?php
						$forma_selecao = '';
						switch ( h($muralestagio->forma_selecao) ) {
							case 0: $forma_selecao = 'Entrevista'; break;
							case 1: $forma_selecao = 'CR';         break;
							case 2: $forma_selecao = 'Prova';      break;
							case 3: $forma_selecao = 'Outra';      break;
						}
						echo $forma_selecao;
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
            </table>
            <div class="text">
                <strong><?= __('Outras') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph($muralestagio->outras); ?>
                </blockquote>
            </div>
			
            <?php if (!empty($muralestagio->inscricoes)) : ?>
            <div class="related">
                <h4><?= __('Inscricoes para o Mural de Estágios') ?></h4>
                <div class="table_wrap">
                    <table>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Aluno') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Timestamp') ?></th>
                        </tr>
                        <?php foreach ($muralestagio->inscricoes as $inscricao) : ?>
                        <tr>
                            <?php // pr($inscricao) ?>
							<td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscricao->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscricao->id)]) ?>
                            </td>
                            <td><?= h($inscricao->id) ?></td>
                            <td><?= $inscricao->aluno ? h($inscricao->aluno->registro) : '' ?></td>
                            <td><?= $inscricao->aluno ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id])  : '' ?></td>
                            <td><?= h($inscricao->data) ?></td>
                            <td><?= h($inscricao->periodo) ?></td>
                            <td><?= $inscricao->timestamp ? h($inscricao->timestamp) : '' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
			<?php endif; ?>
			
        </div>
    </div>
</div>
