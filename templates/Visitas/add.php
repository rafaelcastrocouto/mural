<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="visitas form content">
        <aside>
            <div class="side-nav">
                <?= $this->Html->link(__('Listar Visitas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
            <?= $this->Form->create($visita) ?>
            <fieldset>
                <legend><?= __('Adicionar Visita') ?></legend>
                <?php
                    echo $this->Form->control('instituicao_id', ['options' => $instituicoes, 'class' => 'form-control']);
                    echo $this->Form->control('data');
                    echo $this->Form->control('motivo');
                    echo $this->Form->control('responsavel');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('avaliacao');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
