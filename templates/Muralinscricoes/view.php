<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Muralinscricao'), ['action' => 'edit', $muralinscricao->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Muralinscricao'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricao->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Muralinscricoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Muralinscricao'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="muralinscricoes view content">
            <h3><?= h($muralinscricao->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($muralinscricao->id) ?></td>
                </tr>               
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $muralinscricao->aluno ? $this->Html->link($muralinscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $muralinscricao->alunonovo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Muralestagio') ?></th>
                    <td><?= $muralinscricao->muralestagio ? $this->Html->link($muralinscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricao->muralestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Periodo') ?></th>
                    <td><?= h($muralinscricao->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $this->Number->format($muralinscricao->registro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data') ?></th>
                    <td><?= h($muralinscricao->data) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= h($muralinscricao->timestamp) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
