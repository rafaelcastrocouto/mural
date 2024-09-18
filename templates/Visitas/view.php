<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
//pr($visita);
?>
<div>
    <div class="column-responsive column-80">
        <div class="visitas view content">
            <aside>
                <div class="side-nav">
                    <?= $this->Html->link(__('Editar Visita'), ['action' => 'edit', $visita->id], ['class' => 'side-nav-item']) ?>
                    <?= $this->Form->postLink(__('Deletar Visita'), ['action' => 'delete', $visita->id], ['confirm' => __('Are you sure you want to delete # {0}?', $visita->id), 'class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Listar Visitas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Nova Visita'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <table>
                <tr>
                    <th><?= __('Instituicao') ?></th>
                    <td><?= $visita->instituicao ? $this->Html->link($visita->instituicao->instituicao, ['controller' => 'Instituicao', 'action' => 'view', $visita->instituicao->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Motivo') ?></th>
                    <td><?= h($visita->motivo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Responsavel') ?></th>
                    <td><?= h($visita->responsavel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Avaliacao') ?></th>
                    <td><?= h($visita->avaliacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($visita->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data') ?></th>
                    <td><?= h($visita->data) ?></td>
                </tr>
            </table>
            <div class="text">
                <h2><?= __('Descricao') ?></h2>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($visita->descricao)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
