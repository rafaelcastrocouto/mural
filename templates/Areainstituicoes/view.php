<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="areainstituicoes view content">
            <aside>
                <div class="side-nav">
                    <?= $this->Html->link(__('Editar Area instituicao'), ['action' => 'edit', $areainstituicao->id], ['class' => 'side-nav-item']) ?>
                    <?= $this->Form->postLink(__('Deletear Area instituicao'), ['action' => 'delete', $areainstituicao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $areainstituicao->id), 'class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Listar Area instituicoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Nova Area instituicao'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <h3>areainstituicao_<?= h($areainstituicao->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($areainstituicao->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= h($areainstituicao->area) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
