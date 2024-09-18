<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor[]|\Cake\Collection\CollectionInterface $supervisores
 */
?>
<div class="supervisores index content">
    <?= $this->Html->link(__('New Supervisor'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Supervisores') ?></h3>
    <div>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('cpf') ?></th>
                    <th><?= $this->Paginator->sort('endereco') ?></th>
                    <th><?= $this->Paginator->sort('bairro') ?></th>
                    <th><?= $this->Paginator->sort('municipio') ?></th>
                    <th><?= $this->Paginator->sort('cep') ?></th>
                    <th><?= $this->Paginator->sort('codigo_tel') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('codigo_cel') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('escola') ?></th>
                    <th><?= $this->Paginator->sort('ano_formatura') ?></th>
                    <th><?= $this->Paginator->sort('cress') ?></th>
                    <th><?= $this->Paginator->sort('regiao') ?></th>
                    <th><?= $this->Paginator->sort('outros_estudos') ?></th>
                    <th><?= $this->Paginator->sort('area_curso') ?></th>
                    <th><?= $this->Paginator->sort('ano_curso') ?></th>
                    <th><?= $this->Paginator->sort('cargo') ?></th>
                    <th><?= $this->Paginator->sort('num_inscricao') ?></th>
                    <th><?= $this->Paginator->sort('curso_turma') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supervisores as $supervisor): ?>
                <tr>
                    <td><?= $this->Number->format($supervisor->id) ?></td>
                    <td><?= h($supervisor->nome) ?></td>
                    <td><?= h($supervisor->cpf) ?></td>
                    <td><?= h($supervisor->endereco) ?></td>
                    <td><?= h($supervisor->bairro) ?></td>
                    <td><?= h($supervisor->municipio) ?></td>
                    <td><?= h($supervisor->cep) ?></td>
                    <td><?= h($supervisor->codigo_tel) ?></td>
                    <td><?= h($supervisor->telefone) ?></td>
                    <td><?= h($supervisor->codigo_cel) ?></td>
                    <td><?= h($supervisor->celular) ?></td>
                    <td><?= h($supervisor->email) ?></td>
                    <td><?= h($supervisor->escola) ?></td>
                    <td><?= h($supervisor->ano_formatura) ?></td>
                    <td><?= $this->Number->format($supervisor->cress) ?></td>
                    <td><?= $this->Number->format($supervisor->regiao) ?></td>
                    <td><?= h($supervisor->outros_estudos) ?></td>
                    <td><?= h($supervisor->area_curso) ?></td>
                    <td><?= h($supervisor->ano_curso) ?></td>
                    <td><?= h($supervisor->cargo) ?></td>
                    <td><?= $this->Number->format($supervisor->num_inscricao) ?></td>
                    <td><?= h($supervisor->curso_turma) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $supervisor->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $supervisor->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisor->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
