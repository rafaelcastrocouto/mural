<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="inscricoes view content">
            <aside>
                <div class="side-nav">
                    <?= $this->Html->link(__('Editar Inscricao'), ['action' => 'edit', $inscricao->id], ['class' => 'side-nav-item']) ?>
                    <?= $this->Form->postLink(__('Deletar Inscricao'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscricao->id), 'class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Listar Inscricoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Nova Inscricao'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <h3>inscricao_<?= h($inscricao->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inscricao->id) ?></td>
                </tr>               
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $inscricao->aluno ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Muralestagio') ?></th>
                    <td><?= $inscricao->muralestagio ? $this->Html->link($inscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Periodo') ?></th>
                    <td><?= h($inscricao->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $this->Number->format($inscricao->registro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data') ?></th>
                    <td><?= h($inscricao->data) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= h($inscricao->timestamp) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
