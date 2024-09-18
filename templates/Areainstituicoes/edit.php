<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="areainstituicoes form content">
            <aside>
                <div class="side-nav">
                    <h4 class="heading"><?= __('Actions') ?></h4>
                    <?= $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $areainstituicao->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $areainstituicao->id), 'class' => 'side-nav-item']
                    ) ?>
                    <?= $this->Html->link(__('List Areainstituicoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($areainstituicao) ?>
            <fieldset>
                <legend><?= __('Edit Areainstituicao') ?></legend>
                <?php
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
