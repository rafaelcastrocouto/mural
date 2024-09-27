<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="users view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Usuários'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Editar Usuário'), ['action' => 'edit', $user->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Usuário'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete {0}?', $user->email), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Novo Usuário'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>user_<?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= $user->email ? $this->Text->autoLinkEmails($user->email) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Categoria') ?></th>
                    <td><?= h($user->categoria->categoria); ?></td>
                </tr>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $user->aluno ? $this->Html->link($user->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $user->aluno->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Supervisor') ?></th>
                    <td><?= $user->supervisor ? $this->Html->link($user->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $user->supervisor->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Professor') ?></th>
                    <td><?= $user->professor ? $this->Html->link($user->professor->nome, ['controller' => 'Professor', 'action' => 'view', $user->professor->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $this->Number->format($user->registro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data') ?></th>
                    <td><?= h($user->timestamp) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
