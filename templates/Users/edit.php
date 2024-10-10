<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="users form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Usuários'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Are you sure you want to delete {0}?', $user->email), 'class' => 'button']
                    ) ?>
                </div>
            </aside>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <h3><?= __('Editando user_') . $user->id ?></h3>
                <?php
                    echo $this->Form->control('email', ['type' => 'email']);
                    echo $this->Form->control('password');
                    echo $this->Form->control('categoria', ['options' => $categorias, 'value' => $user->categoria_id, 'class' => 'form-control']);
                    echo $this->Form->control('timestamp', ['type' => 'datetime-local', 'value' => $user->timestamp ? h($user->timestamp) : '']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
