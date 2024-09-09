<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Muralestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="muralestagios form content">
            <?= $this->Form->create($muralestagio) ?>
            <fieldset>
                <legend><?= __('Add Muralestagio') ?></legend>
                <?php
                    echo $this->Form->control('instituicaoestagio_id', ['options' => $instituicaoestagios, 'empty' => true]);
                    echo $this->Form->control('instituicao');
                    echo $this->Form->control('convenio');
                    echo $this->Form->control('vagas');
                    echo $this->Form->control('beneficios');
                    echo $this->Form->control('final_de_semana');
                    echo $this->Form->control('cargaHoraria');
                    echo $this->Form->control('requisitos');
                    echo $this->Form->control('areaestagio_id', ['options' => $areaestagios]);
                    echo $this->Form->control('horario');
                    echo $this->Form->control('docente_id', ['options' => $docentes]);
                    echo $this->Form->control('dataSelecao', ['empty' => true]);
                    echo $this->Form->control('dataInscricao', ['empty' => true]);
                    echo $this->Form->control('horarioSelecao');
                    echo $this->Form->control('localSelecao');
                    echo $this->Form->control('formaSelecao');
                    echo $this->Form->control('contato');
                    echo $this->Form->control('outras');
                    echo $this->Form->control('periodo');
                    echo $this->Form->control('datafax', ['empty' => true]);
                    echo $this->Form->control('localInscricao');
                    echo $this->Form->control('email');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>