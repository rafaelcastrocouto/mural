<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio $areaestagio
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="areaestagios form content">
            <aside>
                <div class="nav">
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $areaestagio->id],
                        ['confirm' => __('Are you sure you want to delete {0}?', $areaestagio->area), 'class' => 'button']
                    ) ?>
                    <?= $this->Html->link(__('Listar Areaestagios'), ['action' => 'index'], ['class' => 'button']) ?>
                </div>
            </aside>
            <?= $this->Form->create($areaestagio) ?>
            <fieldset>
                <legend><?= __('Editando Area estagio') ?></legend>
                <?php
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
