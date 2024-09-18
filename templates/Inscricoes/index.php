<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao[]|\Cake\Collection\CollectionInterface $inscricoes
 */
?>
<div class="inscricoes index content">
    <?= $this->Html->link(__('Nova Inscricao'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inscricoes') ?></h3>
    <div>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('aluno_id') ?></th>
                    <th><?= $this->Paginator->sort('muralestagio_id') ?></th>
                    <th><?= $this->Paginator->sort('data') ?></th>
                    <th><?= $this->Paginator->sort('periodo') ?></th>
                    <th><?= $this->Paginator->sort('timestamp') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscricoes as $inscricao): ?>
                <tr>
                    <td><?= $this->Number->format($inscricao->id) ?></td>
                    <td><?= $this->Number->format($inscricao->registro) ?></td>
                    <td><?= $inscricao->aluno ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id]) : '' ?></td>
                    <td><?= $inscricao->muralestagio ? $this->Html->link($inscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : '' ?></td>
                    <td><?= h($inscricao->data) ?></td>
                    <td><?= h($inscricao->periodo) ?></td>
                    <td><?= h($inscricao->timestamp) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $inscricao->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $inscricao->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscricao->id)]) ?>
                    </td>
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
