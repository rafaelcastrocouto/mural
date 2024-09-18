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
                <div class="side-nav">
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $areaestagio->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $areaestagio->id), 'class' => 'side-nav-item']
                    ) ?>
                    <?= $this->Html->link(__('Listar Areaestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($areaestagio) ?>
            <fieldset>
                <legend><?= __('Editar Area estagio') ?></legend>
                <?php
                    echo $this->Form->control('area');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
