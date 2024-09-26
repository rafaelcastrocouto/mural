<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="areas form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Areas'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $area->id],
                        ['confirm' => __('Are you sure you want to delete {0}?', $area->area), 'class' => 'button']
                    ) ?>
                </div>
            </aside>
            <?= $this->Form->create($area) ?>
            <fieldset>
                <h3><?= __('Editando Area') ?></h3>
                <?php
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>