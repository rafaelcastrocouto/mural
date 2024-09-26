<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
?>
<div class="alunos index content">
    
	<aside>
		<div class="nav">
            <?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'button']) ?>
		</div>
	</aside>
    
    <h3><?= __('Lista de Alunos') ?></h3>
            
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('cpf') ?></th>
                    <th><?= $this->Paginator->sort('nascimento') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <!-- <p> <?= pr($aluno); ?> </p> -->
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $aluno->id], ['confirm' => __('Are you sure you want to delete {0}?', $aluno->nome)]) ?>
                    </td>
                    <td><?= $this->Number->format($aluno->id) ?></td>
                    <td><?= $aluno->nome ? $this->Html->link(h($aluno->nome), ['action' => 'view', $aluno->id]) : '' ?></td>
                    <td><?= $this->Number->format($aluno->registro) ?></td>
                    <td><?= '(' . $aluno->codigo_telefone . ') ' . h($aluno->telefone) ?></td>
                    <td><?= '(' . $aluno->codigo_celular . ') ' . h($aluno->celular) ?></td>
                    <td><?= $aluno->email ? $this->Html->link(h($aluno->email), 'mailto:' . $aluno->email) : '' ?></td>
                    <td><?= h($aluno->cpf) ?></td>
                    <td><?= h($aluno->nascimento) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
