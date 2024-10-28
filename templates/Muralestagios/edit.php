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
                <div class="nav">
                    <?= $this->Html->link(__('Listar Muralestagios'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $muralestagio->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagio->id), 'class' => 'button']
                    ) ?>
                </div>
            </aside>
            <?= $this->Form->create($muralestagio) ?>
            <fieldset>
                <legend><?= __('Editando Muralestagio') ?></legend>
                <?php
                    echo $this->Form->control('instituicao');
                    echo $this->Form->control('convenio');
                    echo $this->Form->control('email');
                    echo $this->Form->control('vagas');
                    echo $this->Form->control('beneficios');
                    echo $this->Form->control('fim_de_semana');
                    echo $this->Form->control('carga_horaria');
                    echo $this->Form->control('requisitos');
                    echo $this->Form->control('turmaestagio_id', ['options' => $turmaestagios, 'class' => 'form-control']);
                    echo $this->Form->control('turno');
                    echo $this->Form->control('professor_id', ['options' => $professores, 'class' => 'form-control']);
                    echo $this->Form->control('local_inscricao');
                    echo $this->Form->control('data_inscricao', ['empty' => true]);
                    echo $this->Form->control('local_selecao');
                    echo $this->Form->control('data_selecao', ['empty' => true]);
                    echo $this->Form->control('horario_selecao');
                    echo $this->Form->control('forma_selecao');
                    echo $this->Form->control('contato');
                    echo $this->Form->control('periodo');
                    echo $this->Form->control('outras');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
