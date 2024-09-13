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
            <?= $this->Html->link(__('Edit Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Estagiarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Estagiario'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="estagiarios view content">
            <h3><?= h($estagiario->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $estagiario->has('aluno') ? $this->Html->link($estagiario->aluno->id, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Ajustecurricular2020') ?></th>
                    <td><?= h($estagiario->ajustecurricular2020) ?></td>
                </tr>
                <tr>
                    <th><?= __('Turno') ?></th>
                    <td><?= h($estagiario->turno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nivel') ?></th>
                    <td><?= h($estagiario->nivel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituicaoestagio') ?></th>
                    <td><?= $estagiario->has('instituicaoestagio') ? $this->Html->link($estagiario->instituicaoestagio->id, ['controller' => 'Instituicaoestagios', 'action' => 'view', $estagiario->instituicaoestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Supervisor') ?></th>
                    <td><?= $estagiario->has('supervisor') ? $this->Html->link($estagiario->supervisor->id, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Docente') ?></th>
                    <td><?= $estagiario->has('docente') ? $this->Html->link($estagiario->docente->id, ['controller' => 'Docentes', 'action' => 'view', $estagiario->docente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Periodo') ?></th>
                    <td><?= h($estagiario->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Areaestagio') ?></th>
                    <td><?= $estagiario->has('areaestagio') ? $this->Html->link($estagiario->areaestagio->id, ['controller' => 'Areaestagios', 'action' => 'view', $estagiario->areaestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Observacoes') ?></th>
                    <td><?= h($estagiario->observacoes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($estagiario->id) ?></td>
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
