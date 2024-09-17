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
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Adicionar User') ?></legend>
                <?php
                    echo $this->Form->control('email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('categoria', ['options' => $categorias, 'value' => '2', 'class' => 'form-control']);
                    echo $this->Form->control('numero');
                    echo $this->Form->control('aluno_id', ['type' => 'text']);
                    echo $this->Form->control('supervisor_id', ['type' => 'text']);
                    echo $this->Form->control('professor_id', ['type' => 'text']);
                    echo $this->Form->control('data', ['type' => 'datetime-local']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
