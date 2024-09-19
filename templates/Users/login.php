<div class="users form content">
    <aside>
        <div class="side-nav">
            <?= $this->Html->link(__('Adicionar User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Fazer login') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>