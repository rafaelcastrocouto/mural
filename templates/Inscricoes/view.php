<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="inscricoes view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Inscricoes'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Editar Inscricao'), ['action' => 'edit', $inscricao->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Inscricao'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Are you sure you want to delete inscricao_{0}?', $inscricao->id), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Nova Inscricao'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>inscricao_<?= h($inscricao->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($inscricao->id) ?></td>
                </tr>               
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $inscricao->aluno ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Estágio') ?></th>
                    <td><?= $inscricao->muralestagio ? $this->Html->link($inscricao->muralestagio->instituicao ?'Vaga para '. $inscricao->muralestagio->instituicao->instituicao : $inscricao->muralestagio->id , ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : $inscricao->muralestagio_id ?></td>
                </tr>
                <tr>
                    <th><?= __('Período') ?></th>
                    <td><?= h($inscricao->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Alteração') ?></th>
                    <td><?= $inscricao->data ? h($inscricao->data) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Criação') ?></th>
                    <td><?= $inscricao->timestamp ? h($inscricao->timestamp) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
