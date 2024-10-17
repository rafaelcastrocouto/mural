<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users index content">
	<aside>
		<div class="nav">
            <?= $this->Html->link(__('Novo usuário'), ['action' => 'add'], ['class' => 'button']) ?>
		</div>
	</aside>
    
    <h3><?= __('Lista de usuários') ?></h3>
    
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('categoria_id', 'Categoria') ?></th>
                    <th><?= $this->Paginator->sort('Alunos.nome', 'Nome') ?></th>
                    <th><?= $this->Paginator->sort('timestamp') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                    </td>
                    <td><?= $this->Html->link($user->id, ['action' => 'view', $user->id]) ?></td>
                    <td><?= $user->email ? $this->Text->autoLinkEmails($user->email) : '' ?></td>
                    <td><?= h($user->categoria->categoria) ?></td>
                    <td>
                    <?php
                    switch ($user->categoria_id) {
                        case 1: // Administrador
                            echo $user->administrador ? $this->Html->link($user->administrador->nome, ['controller' => 'Administradores', 'action' => 'view', $user->administrador->id]) : $this->Html->link('Criar administrador', ['controller' => 'Administradores', 'action' => 'add']);
                            break;
                        case 2: // Aluno
                            echo $user->aluno ? $this->Html->link($user->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $user->aluno->id]) : $this->Html->link('Criar aluno', ['controller' => 'Alunos', 'action' => 'add', $user->id]);
                            break;
                        case 3: // Professor
                            echo $user->professor ? $this->Html->link($user->professor->nome, ['controller' => 'Professores', 'action' => 'view', $user->professor->id]) : $this->Html->link('Criar professor', ['controller' => 'Professores', 'action' => 'add']);
                            break;
                        case 4: // Supervisor
                            echo $user->supervisor ? $this->Html->link($user->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $user->supervisor->id]) : $this->Html->link('Criar supervisor', ['controller' => 'Supervisores', 'action' => 'add']);
                            break;
                        default:
                            echo 'Categoria invalida';
                    }
                    ?>
                    </td>
                    <td><?= $user->timestamp ? h($user->timestamp) : '' ?></td>
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
