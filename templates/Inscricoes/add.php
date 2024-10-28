<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
?>
<div class="inscricoes form content">
    <aside>
        <div class="nav">
            <?= $this->Html->link(__('Listar Inscricoes'), ['action' => 'index'], ['class' => 'button']) ?>
        </div>
    </aside>
    <?= $this->Form->create($inscricao) ?>
    <fieldset>
        <h3><?= __('Adicionar Inscricao') ?></h3>
        <?php
            echo $this->Form->control('registro');
            echo $this->Form->control('aluno_id', ['type' => 'text', 'value' => $aluno ? $aluno->id : '']);
            echo $this->Form->control('muralestagio_id', ['type' => 'text', 'value' => $mural_estagio_id ? $mural_estagio_id : '']);
            echo $this->Form->control('data');
            echo $this->Form->control('periodo');
            echo $this->Form->control('timestamp');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Inscrever'), ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</div>
