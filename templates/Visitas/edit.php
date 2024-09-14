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
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $visita->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $visita->id), 'class' => 'side-nav-item']
                ) ?>
                <?= $this->Html->link(__('Listar Visitas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
            <?= $this->Form->create($visita) ?>
            <fieldset>
                <h2><?= __('Editando Visita') ?></h2>
                <?php
                    echo $this->Form->control('instituicaoestagio_id', ['options' => $instituicaoestagios]);
                    echo $this->Form->control('data');
                    echo $this->Form->control('motivo');
                    echo $this->Form->control('responsavel');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('avaliacao');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
