<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao[]|\Cake\Collection\CollectionInterface $avaliacoes
 */

$categoria_id = $session? (int) $session->get('categoria_id') : 2;

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
                        <td><?= $this->Html->link($avaliacao->id, ['action' => 'view', $avaliacao->id]) ?></td>
                        <td><?= ($avaliacao->estagiario and $avaliacao->estagiario->aluno) ? $this->Html->link($avaliacao->estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $avaliacao->estagiario->aluno->id]) : '' ?></td>
                                                <td><?= ($avaliacao->estagiario and $avaliacao->estagiario->instituicao) ? $this->Html->link($avaliacao->estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $avaliacao->estagiario->instituicao->id]) : '' ?></td>
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
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Avaliação') ?></th>
                        <th><?= $this->Paginator->sort('estagiario->aluno->nome', 'Aluno') ?></th>
                        <th><?= $this->Paginator->sort('estagiario->periodo', 'Período') ?></th>
                        <th><?= $this->Paginator->sort('estagiario->nivel', 'Nível') ?></th>
                        <th><?= $this->Paginator->sort('estagiario->instituicao->instituicao', 'Instituição') ?></th>
                        <th><?= $this->Paginator->sort('estagiario->supervisor->nome', 'Supervisor(a)') ?></th>
                        <th><?= $this->Paginator->sort('estagiario->ch', 'Carga horária') ?></th>
                        <th><?= $this->Paginator->sort('estagiario->nota', 'Nota') ?></th>
                        <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estagiario as $c_estagiario): ?>
                        <?php // pr($c_estagiario); ?>
                        <?php // die(); ?>
                        <tr>
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                <td><?= isset($c_estagiario->id) ? $this->Html->link($c_estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) : '' ?>
                                </td>
                            <?php else: ?>
                                <td><?= isset($c_estagiario->id) ? $c_estagiario->id : '' ?></td>
                            <?php endif; ?>
    
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 4): ?>
                                <td><?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : $this->Html->link('Fazer avaliação', ['controller' => 'avaliacoes', 'action' => 'add', $c_estagiario->id], ['class' => 'btn btn-warning']) ?>
                                </td>
                            <?php else: ?>
                                <td><?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : 'Sem avaliação on-line' ?>
                                </td>
                            <?php endif; ?>
    
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                <td><?= $c_estagiario->hasValue('aluno') ? $this->Html->link($c_estagiario->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $c_estagiario->aluno->id]) : '' ?>
                                </td>
                            <?php else: ?>
                                <td><?= $c_estagiario->hasValue('aluno') ? $c_estagiario->aluno->nome : '' ?></td>
                            <?php endif; ?>
    
                            <td><?= $c_estagiario->periodo ?></td>
                            <td><?= $c_estagiario->nivel ?></td>
                            <td><?= $c_estagiario->hasValue('instituicao') ? $c_estagiario->instituicao->instituicao : '' ?>
                            </td>
                            <td><?= $c_estagiario->hasValue('supervisor') ? $c_estagiario->supervisor->nome : '' ?></td>
                            <td><?= $c_estagiario->ch ?></td>
                            <td><?= $c_estagiario->nota ?></td>
    
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                <?php if (isset($c_estagiario->avaliacao->id)): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_estagiario->avaliacao->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_estagiario->avaliacao->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_estagiario->avaliacao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $c_estagiario->avaliacao->id)]) ?>
                                    </td>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    
    <?php endif; ?>
</div>