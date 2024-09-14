<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
?>
<div>
    <aside>
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Editar Area instituicao'), ['action' => 'edit', $areainstituicao->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Deletear Area instituicao'), ['action' => 'delete', $areainstituicao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $areainstituicao->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Listar Area instituicoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Nova Area instituicao'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areainstituicoes view content">
            <h3><?= h($areainstituicao->area) ?></h3>
            <table>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= h($areainstituicao->area) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($areainstituicao->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
