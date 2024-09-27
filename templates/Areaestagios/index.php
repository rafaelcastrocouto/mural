<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio[]|\Cake\Collection\CollectionInterface $areaestagios
 */
?>
<div class="areaestagios index content">
    
	<aside>
		<div class="nav">
            <?= $this->Html->link(__('Nova Areaestagio'), ['action' => 'add'], ['class' => 'button']) ?>
		</div>
	</aside>
            
    <h3><?= __('Lista de Areaestagios') ?></h3>
    
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('area') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($areaestagios as $areaestagio): ?>
                <tr>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $areaestagio->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $areaestagio->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $areaestagio->id], ['confirm' => __('Are you sure you want to delete {0}?', $areaestagio->area)]) ?>
                    </td>
                    <td><?= $this->Number->format($areaestagio->id) ?></td>
                    <td><?= $this->Html->link(h($areaestagio->area), ['action' => 'view', $areaestagio->id]) ?></td>
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
