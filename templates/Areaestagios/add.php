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
                <div class="nav">
                    <?= $this->Html->link(__('Listar Areaestagios'), ['action' => 'index'], ['class' => 'button']) ?>
                </div>
            </aside>
            <?= $this->Form->create($areaestagio) ?>
            <fieldset>
                <h3><?= __('Adicionando Area estagio') ?></h3>
                <?php
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
