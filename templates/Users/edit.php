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
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']
                    ) ?>
                    <?= $this->Html->link(__('Listar Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Editando User') ?></legend>
                <?php
                    echo $this->Form->control('email', ['type' => 'email']);
                    echo $this->Form->control('password');
                    echo $this->Form->control('categoria', ['options' => $categorias, 'value' => $user->categoria_id,'class' => 'form-control']);
                    echo $this->Form->control('registro');
                    echo $this->Form->control('aluno_id', ['type' => 'text', 'value' => $user->aluno_id]);
                    echo $this->Form->control('supervisor_id', ['type' => 'text', 'value' => $user->supervisor_id]);
                    echo $this->Form->control('professor_id', ['type' => 'text', 'value' => $user->professor_id]);
                    echo $this->Form->control('data', ['type' => 'datetime-local', 'value' => $user->data ? $user->data->format('Y-m-d\TH:i') : '']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
