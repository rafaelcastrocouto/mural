<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="turmaestagios form content">
            <aside>
                <div class="nav">
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $turmaestagio->id],
                        ['confirm' => __('Are you sure you want to delete {0}?', $turmaestagio->turma), 'class' => 'button']
                    ) ?>
                    <?= $this->Html->link(__('Listar Turma estagios'), ['action' => 'index'], ['class' => 'button']) ?>
                </div>
            </aside>
            <?= $this->Form->create($turmaestagio) ?>
            <fieldset>
                <legend><?= __('Editando Turma estagio') ?></legend>
                <?php
                    echo $this->Form->control('turma');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
