<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade[]|\Cake\Collection\CollectionInterface $folhadeatividades
 */
// pr($estagiario->item->aluno);
// die();

$categoria_id = 0;
$user_session = $this->request->getAttribute('identity');
if ($user_session) { $categoria_id = $session->get('categoria_id'); }

?>

<div class="folhadeatividades index content">
    
    <h3><?= __('Estágios cursados pela(o) estudande ') ?></h3>
    
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <?php if (categoria_id == 1): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Folha de atividades') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->aluno->nome', 'Aluno') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->periodo', 'Período') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->nivel', 'Nível') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->instituicao->instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->supervisor->nome', 'Supervisor(a)') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->ch', 'Carga horária') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->nota', 'Nota') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estagiario as $c_estagiario): ?>
                    <?php // pr($c_estagiario); ?>
                    <?php // die(); ?>
                    <tr>

                        <?php if ($categoria_id == 1): ?> 
                            <?php if (isset($c_estagiario->id)): ?>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $c_estagiario->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $c_estagiario->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $c_estagiario->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $c_estagiario->id)]) ?>
                                </td>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php if ($categoria_id == 1): ?>
                            <td><?= isset($c_estagiario->id) ? $this->Html->link($c_estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= isset($c_estagiario->id) ? $c_estagiario->id : '' ?></td>
                        <?php endif; ?>

                        <td><?= $this->Html->link('Preencher folha de atividades', ['controller' => 'folhadeatividades', 'action' => 'index', $c_estagiario->id]) ?></td>

                        <?php if ($categoria_id == 1): ?>
                            <td><?= $c_estagiario->hasValue('aluno') ? $this->Html->link($c_estagiario->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $c_estagiario->aluno->id]) : '' ?></td>
                        <?php else: ?>
                            <td><?= $c_estagiario->hasValue('aluno') ? $c_estagiario->aluno->nome : '' ?></td>
                        <?php endif; ?>

                        <td><?= $c_estagiario->periodo ?></td>
                        <td><?= $c_estagiario->nivel ?></td>
                        <td><?= $c_estagiario->hasValue('instituicao') ? $c_estagiario->instituicao->instituicao : '' ?></td>
                        <td><?= $c_estagiario->hasValue('supervisor') ? $c_estagiario->supervisor->nome : '' ?></td>
                        <td><?= $c_estagiario->ch ?></td>
                        <td><?= $c_estagiario->nota ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <?= $this->element('paginator'); ?>
        <?= $this->element('paginator_count'); ?>
    </div>
</div>
