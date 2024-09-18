<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao[]|\Cake\Collection\CollectionInterface $muralinscricoes
 */
?>
<div class="muralinscricoes index content">
    <?= $this->Html->link(__('New Muralinscricao'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Muralinscricoes') ?></h3>
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
                <?php foreach ($muralinscricoes as $muralinscricao): ?>
                <tr>
                    <td><?= $this->Number->format($muralinscricao->id) ?></td>
                    <td><?= $this->Number->format($muralinscricao->registro) ?></td>
                    <td><?= $muralinscricao->has('aluno') ? $this->Html->link($muralinscricao->aluno->id, ['controller' => 'Alunos', 'action' => 'view', $muralinscricao->aluno->id]) : '' ?></td>
                    <td><?= $muralinscricao->has('muralestagio') ? $this->Html->link($muralinscricao->muralestagio->id, ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricao->muralestagio->id]) : '' ?></td>
                    <td><?= h($muralinscricao->data) ?></td>
                    <td><?= h($muralinscricao->periodo) ?></td>
                    <td><?= h($muralinscricao->timestamp) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $muralinscricao->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $muralinscricao->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricao->id)]) ?>
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
