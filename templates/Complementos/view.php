<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="complementos view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Complementos'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Editar Complemento'), ['action' => 'edit', $complemento->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Complemento'), ['action' => 'delete', $complemento->id], ['confirm' => __('Are you sure you want to delete {0}?', $complemento->nome), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Novo Complemento'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>admin_<?= h($complemento->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($complemento->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($complemento->nome) ?></td>
                </tr>
            </table>
            
            <?php if (!empty($complemento->user)) : ?>
            <div class="related">
                <h4><?= __('Related User') ?></h4>
                <div class="table_wrap">
                    <table>
                        <tr>
                            <th class="actions"><?= __('Actions') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Data') ?></th>
                        </tr>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Users', 'action' => 'view', $complemento->user->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Users', 'action' => 'edit', $complemento->user->id]) ?>
                                <?= $this->Form->postLink(__('Deletar'), ['controller' => 'Users', 'action' => 'delete', $complemento->user->id], ['confirm' => __('Are you sure you want to delete user_{0}?', $complemento->user->id)]) ?>
                            </td>
                            <td><?= $this->Html->link($complemento->user->id, ['controller' => 'Users', 'action' => 'view', $complemento->user->id]) ?></td>
                            <td><?= $complemento->user->email ? $this->Text->autoLinkEmails($complemento->user->email) : '' ?></td>
                            <td><?= h($complemento->user->timestamp) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>
