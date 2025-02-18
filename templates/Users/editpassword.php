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
            <?php 
            echo $this->Html->link(__('Ver Usuário'), ['action' => 'view', $user->id], ['class' => 'button']);
            if ($categoria_id == 1):
                echo $this->Html->link(__('Listar Usuários'), ['action' => 'index'], ['class' => 'button']);
                echo $this->Form->postLink( __('Deletar'), ['action' => 'delete', $user->id],
                    ['confirm' => __('Are you sure you want to delete user_{0}?', $user->email), 'class' => 'button']
                ); 
            endif; ?>
        </div>
    </aside>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <h3><?= __('Editando senha user_') . $user->id ?></h3>
        <?php
            echo $this->Form->control('password', ['value' => '', 'label' => 'Nova senha', 'placeholder' => 'nova senha', 'id' => 'password', 'required' => false]);
            echo $this->element('show_password');
            //echo $this->Form->control('categoria_id', ['options' => $categorias, 'value' => $user->categoria_id, 'class' => 'form-control']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Alterar Senha'), ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</div>
