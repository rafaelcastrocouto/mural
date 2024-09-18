<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $estagiario->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Estagiarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="estagiarios form content">
            <?= $this->Form->create($estagiario) ?>
            <fieldset>
                <legend><?= __('Edit Estagiario') ?></legend>
                <?php
                    echo $this->Form->control('aluno_id', ['options' => $alunos]);
                    echo $this->Form->control('registro');
                    echo $this->Form->control('ajustecurricular2020');
                    echo $this->Form->control('turno');
                    echo $this->Form->control('nivel');
                    echo $this->Form->control('tc');
                    echo $this->Form->control('tc_solicitacao', ['empty' => true]);
                    echo $this->Form->control('instituicao_id', ['options' => $instituicoes]);
                    echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'empty' => true]);
                    echo $this->Form->control('professor_id', ['options' => $professores, 'empty' => true]);
                    echo $this->Form->control('periodo');
                    echo $this->Form->control('areaestagio_id', ['options' => $areaestagios, 'empty' => true]);
                    echo $this->Form->control('nota');
                    echo $this->Form->control('ch');
                    echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
