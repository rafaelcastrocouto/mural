<?php

declare(strict_types=1);

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao[]|\Cake\Collection\CollectionInterface $avaliacoes
 */

$categoria_id = 0;
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $categoria_id = $user_session->get('categoria_id'); }

?>
<div class="avaliacoes index content">

    <?php if ( $categoria_id == 1 || $categoria_id == 3 || $categoria_id == 4 ): ?>

        <aside>
            <div class="nav">
                <?= $this->Html->link(__('Nova Avaliação'), ['action' => 'add', $id], ['class' => 'button']) ?>
            </div>
        </aside>

    <?php endif; ?>
    
    <?php if ( $categoria_id == 1 ): ?>
    
        <h3><?= __('Lista de Avaliações') ?></h3>
    
        <div class="paginator">
            <?= $this->element('paginator'); ?>
        </div>
        <div class="table_wrap">
            <table>
                <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('Estagiarios.Alunos.nome', 'Aluno') ?></th>
                    <th><?= $this->Paginator->sort('Estagiarios.Instituicoes.instituicao', 'Instituicao') ?></th>
                    <th><?= $this->Paginator->sort('avaliacao1') ?></th>
                    <th><?= $this->Paginator->sort('timestamp') ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($avaliacoes as $avaliacao): ?>
                    <tr>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $avaliacao->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $avaliacao->id]) ?>
                            <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $avaliacao->id], ['confirm' => __('Are you sure you want to delete {0}?', $avaliacao->id)]) ?>
                        </td>
                        <td><?= $this->Html->link((string)$avaliacao->id, ['action' => 'view', $avaliacao->id]) ?></td>
                        <td><?= ($avaliacao->estagiario and $avaliacao->estagiario->aluno) ? $this->Html->link(h($avaliacao->estagiario->aluno->nome), ['controller' => 'Alunos', 'action' => 'view', $avaliacao->estagiario->aluno->id]) : '' ?></td>
                                                <td><?= ($avaliacao->estagiario and $avaliacao->estagiario->instituicao) ? $this->Html->link(h($avaliacao->estagiario->instituicao->instituicao), ['controller' => 'Instituicoes', 'action' => 'view', $avaliacao->estagiario->instituicao->id]) : '' ?></td>
                        <td><?= h($avaliacao->avaliacao1) ?></td>
                        <td><?= h($avaliacao->timestamp) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator">
            <?= $this->element('paginator'); ?>
            <?= $this->element('paginator_count'); ?>
        </div>

	<?php else: ?>
    
        <div class="table-responsive">
            <table class="table table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <?php if ($categoria_id == 1): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <?php endif; ?>
                        <th><?= $this->Paginator->sort('estagiarios->avaliacao->id', 'Avaliação') ?></th>
                        <th><?= $this->Paginator->sort('estagiarios->aluno->nome', 'Aluno') ?></th>
                        <th><?= $this->Paginator->sort('estagiarios->periodo', 'Período') ?></th>
                        <th><?= $this->Paginator->sort('estagiarios->nivel', 'Nível') ?></th>
                        <th><?= $this->Paginator->sort('estagiarios->instituicao->instituicao', 'Instituição') ?></th>
                        <th><?= $this->Paginator->sort('estagiarios->supervisor->nome', 'Supervisor(a)') ?></th>
                        <th><?= $this->Paginator->sort('estagiarios->ch', 'Carga horária') ?></th>
                        <th><?= $this->Paginator->sort('estagiarios->nota', 'Nota') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estagiarios as $estagiario): ?>
                        <?php // pr($estagiario); ?>
                        <?php // die(); ?>
                        <tr>
                            <?php if ($categoria_id == 1): ?>
                                <?php if (isset($estagiario->avaliacao->id)): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $estagiario->avaliacao->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estagiario->avaliacao->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estagiario->avaliacao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiario->avaliacao->id)]) ?>
                                    </td>
                                <?php endif; ?>
                                <td><?= isset((string)$estagiario->id) ? $this->Html->link($estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $estagiario->id]) : '' ?>
                                </td>
                            <?php else: ?>
    
                            <?php if ($categoria_id == 1 || $categoria_id == 4): ?>
                                <td><?= $estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $estagiario->avaliacao->id], ['class' => 'btn btn-success']) : $this->Html->link('Fazer avaliação', ['controller' => 'avaliacoes', 'action' => 'add', $estagiario->id], ['class' => 'btn btn-warning']) ?>
                                </td>
                            <?php else: ?>
                                <td><?= $estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $estagiario->avaliacao->id], ['class' => 'btn btn-success']) : 'Sem avaliação on-line' ?>
                                </td>
                            <?php endif; ?>
    
                            <?php if ($categoria_id == 1): ?>
                                <td><?= $estagiario->hasValue('aluno') ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?>
                                </td>
                            <?php else: ?>
                                <td><?= $estagiario->hasValue('aluno') ? $estagiario->aluno->nome : '' ?></td>
                            <?php endif; ?>
    
                            <td><?= $estagiario->periodo ?></td>
                            <td><?= $estagiario->nivel ?></td>
                            <td><?= $estagiario->hasValue('instituicao') ? $estagiario->instituicao->instituicao : '' ?>
                            </td>
                            <td><?= $estagiario->hasValue('supervisor') ? $estagiario->supervisor->nome : '' ?></td>
                            <td><?= $estagiario->ch ?></td>
                            <td><?= $estagiario->nota ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    
    <?php endif; ?>
</div>