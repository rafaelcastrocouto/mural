<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio $areaestagio
 */
?>
<div
    <div class="column-responsive column-80">
        <div class="areaestagios form content">
            <aside>
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar Areaestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($areaestagio) ?>
            <fieldset>
                <legend><?= __('Adicionar Area estagio') ?></legend>
                <?php
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
