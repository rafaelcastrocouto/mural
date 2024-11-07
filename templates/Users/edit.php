<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?php
$categoria_id = 0;
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $categoria_id = $user_session->get('categoria_id'); }
?>
    
<div class="users form content">
    <aside>
        <div class="nav">
            <?php if ($categoria_id == 1): ?>
                <?= $this->Html->link(__('Listar Usuários'), ['action' => 'index'], ['class' => 'button']) ?>
            <?= $this->Form->postLink(
                __('Deletar'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete user_{0}?', $user->email), 'class' => 'button']
            ) ?>
            <?php endif; ?>
        </div>
    </aside>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <h3><?= __('Editando user_') . $user->id ?></h3>
        <?php
            echo $this->Form->control('email', ['type' => 'email', 'required' => true]);
            if ($categoria_id != 1):
                echo $this->Form->control('current_password', ['id' => 'current-password', 'label' => 'Senha atual', 'autocomplete' => 'current-password']);
            endif;
            echo $this->Form->control('password1', ['id' => 'new-password', 'label' => 'Nova senha', 'required' => true]);
            echo $this->Form->control('password2', ['label' => 'Digite novamente', 'required' => true]);
            echo $this->Form->control('categoria', ['options' => $categorias, 'value' => $user->categoria_id, 'class' => 'form-control', 'required' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Editar'), ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</div>
