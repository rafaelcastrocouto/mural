<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="estagiarios view content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Estagiarios'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(__('Deletar Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete estagiario #{0}?', $estagiario->id), 'class' => 'button']) ?>
                    <?= $this->Html->link(__('Novo Estagiario'), ['action' => 'add'], ['class' => 'button']) ?>
                </div>
            </aside>
            <h3>estagiario_<?= h($estagiario->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($estagiario->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $estagiario->aluno ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Ajustecurricular2020') ?></th>
                    <td><?= h($estagiario->ajustecurricular2020) ?></td>
                </tr>
                <tr>
                    <th><?= __('Turno') ?></th>
                    <td>
                    <?php
                    switch ( h($estagiario->turno) ) {
                        case 'D': $turno = 'Diurno'; break;
                        case 'N': $turno = 'Noturno'; break;
                        case 'A': $turno = 'Ambos'; break;
                        default: $turno = '-';
                    }
                    echo $turno;
                    ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Nivel') ?></th>
                    <td><?= h($estagiario->nivel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituicao') ?></th>
                    <td><?= $estagiario->instituicao ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Supervisor') ?></th>
                    <td><?= $estagiario->supervisor ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Professor') ?></th>
                    <td><?= $estagiario->professor ? $this->Html->link($estagiario->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Periodo') ?></th>
                    <td><?= h($estagiario->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Turmaestagio') ?></th>
                    <td><?= $estagiario->turmaestagio ? $this->Html->link($estagiario->turmaestagio->turma, ['controller' => 'Turmaestagios', 'action' => 'view', $estagiario->turmaestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Observacoes') ?></th>
                    <td><?= h($estagiario->observacoes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $this->Number->format($estagiario->registro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tc') ?></th>
                    <td><?= $this->Number->format($estagiario->tc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nota') ?></th>
                    <td><?= $this->Number->format($estagiario->nota) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ch') ?></th>
                    <td><?= $this->Number->format($estagiario->ch) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tc Solicitacao') ?></th>
                    <td><?= h($estagiario->tc_solicitacao) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
