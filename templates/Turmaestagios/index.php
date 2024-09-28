<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio[]|\Cake\Collection\CollectionInterface $turmaestagios
 */
?>
<div class="turmaestagios index content">
    
	<aside>
		<div class="nav">
            <?= $this->Html->link(__('Nova Turmaestagio'), ['action' => 'add'], ['class' => 'button']) ?>
		</div>
	</aside>
            
    <h3><?= __('Lista de Turmaestagios') ?></h3>
    
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('turma') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turmaestagios as $turmaestagio): ?>
                <tr>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $turmaestagio->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $turmaestagio->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $turmaestagio->id], ['confirm' => __('Are you sure you want to delete {0}?', $turmaestagio->turma)]) ?>
                    </td>
                    <td><?= $this->Number->format($turmaestagio->id) ?></td>
                    <td><?= $this->Html->link(h($turmaestagio->turma), ['action' => 'view', $turmaestagio->id]) ?></td>
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
