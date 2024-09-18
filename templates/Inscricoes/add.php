<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
?>
<div">
    <div class="column-responsive column-80">
        <div class="inscricoes form content">
            <aside>
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar Inscricoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($inscricao) ?>
            <fieldset>
                <legend><?= __('Adicionar Inscricao') ?></legend>
                <?php
                    echo $this->Form->control('registro');
                    echo $this->Form->control('aluno_id', ['options' => $alunos, 'empty' => true]);
                    echo $this->Form->control('muralestagio_id', ['options' => $muralestagios]);
                    echo $this->Form->control('data');
                    echo $this->Form->control('periodo');
                    echo $this->Form->control('timestamp');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Inscrever')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
