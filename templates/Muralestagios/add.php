<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="muralestagios form content">
            <aside>
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar Muralestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($muralestagio) ?>
            <fieldset>
                <legend><?= __('Adicionar Mural estagio') ?></legend>
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
                    echo $this->Form->control('professor_id', ['options' => $professores]);
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
