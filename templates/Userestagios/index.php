<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio[]|\Cake\Collection\CollectionInterface $userestagios
 */
?>
<div class="userestagios index content">
    <?= $this->Html->link(__('New Userestagio'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Userestagios') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('categoria') ?></th>
                    <th><?= $this->Paginator->sort('numero') ?></th>
                    <th><?= $this->Paginator->sort('aluno_id') ?></th>
                    <th><?= $this->Paginator->sort('supervisor_id') ?></th>
                    <th><?= $this->Paginator->sort('docente_id') ?></th>
                    <th><?= $this->Paginator->sort('timestamp') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userestagios as $userestagio): ?>
                <tr>
                    <td><?= $this->Number->format($userestagio->id) ?></td>
                    <td><?= h($userestagio->email) ?></td>
                    <td><?= h($userestagio->categoria) ?></td>
                    <td><?= $this->Number->format($userestagio->numero) ?></td>
                    <td><?= $userestagio->has('aluno') ? $this->Html->link($userestagio->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $userestagio->aluno->id]) : '' ?></td>
                    <td><?= $userestagio->has('supervisor') ? $this->Html->link($userestagio->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $userestagio->supervisor->id]) : '' ?></td>
                    <td><?= $userestagio->has('docente') ? $this->Html->link($userestagio->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $userestagio->docente->id]) : '' ?></td>
                    <td><?= h($userestagio->timestamp) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $userestagio->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userestagio->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userestagio->id)]) ?>
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
