<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrador $administrador
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="administradores view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Administradores'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Editar Administrador'), ['action' => 'edit', $administrador->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Administrador'), ['action' => 'delete', $administrador->id], ['confirm' => __('Are you sure you want to delete {0}?', $administrador->nome), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Novo Administrador'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>admin_<?= h($administrador->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($administrador->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($administrador->nome) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
