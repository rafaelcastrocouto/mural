<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */

//pr($alunos);
//die();

$categoria_id = 0;
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $categoria_id = $user_session->get('categoria_id'); }
    
?>
<div class="alunos index content">
    
	<aside>
		<div class="nav">
            <?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'button']) ?>
		</div>
	</aside>
    
    <h3><?= __('Lista de Alunos') ?></h3>
    
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
				    <?php if ($categoria_id == 1): ?>
                        <th class="actions"><?= __('Actions') ?></th>
                        <th><?= $this->Paginator->sort('id') ?></th>
                    <?php endif; ?>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('cpf') ?></th>
                    <th><?= $this->Paginator->sort('nascimento') ?></th>
                    <th><?= $this->Paginator->sort('estagiario_count') ?></th>
                    <th><?= $this->Paginator->sort('inscricao_count') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                <tr>
				    <?php if ($categoria_id == 1): ?>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $aluno->id], ['confirm' => __('Are you sure you want to delete {0}?', $aluno->nome)]) ?>
                    </td>
                    <td><?= $this->Html->link($aluno->id, ['action' => 'view', $aluno->id]) ?></td>
                    <?php endif; ?>
                    <td><?= $aluno->nome ? $this->Html->link(h($aluno->nome), ['action' => 'view', $aluno->id]) : '' ?></td>
                    <td><?= h($aluno->registro) ?></td>
                    <td><?= ($aluno->user and $aluno->user->email) ? $this->Text->autoLinkEmails($aluno->user->email) : '' ?></td>
                    <td><?= $aluno->telefone ? '(' . $aluno->codigo_telefone . ') ' . h($aluno->telefone) : '' ?></td>
                    <td><?= $aluno->celular ? '(' . $aluno->codigo_celular . ') ' . h($aluno->celular) : '' ?></td>
                    <td><?= h($aluno->cpf) ?></td>
                    <td><?= h($aluno->nascimento) ?></td>
                    <td><?= h($aluno->estagiario_count) ?></td>
                    <td><?= h($aluno->inscricao_count) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <?= $this->element('paginator'); ?>
        <?= $this->element('paginator_count'); ?>
    </div>
</div>
