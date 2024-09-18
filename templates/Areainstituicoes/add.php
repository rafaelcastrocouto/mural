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
                    <?= $this->Html->link(__('Listar Area instituicoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($areainstituicao) ?>
            <fieldset>
                <legend><?= __('Adicionar Area instituicao') ?></legend>
                <?php
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
