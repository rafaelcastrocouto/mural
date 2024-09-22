<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
// pr($estagiarios);
// pr($periodo);
?>

<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios']); ?>";
        var estagiarioperiodo = $("#EstagiarioPeriodo");
		var pathname = location.pathname.split('/').filter(Boolean);
		if (pathname[pathname.length - 2] == 'index') estagiarioperiodo.val(pathname[pathname.length - 1]);
        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            window.location = url + '/index/' + periodo;
        });
    });
</script>

<?php
// $this->request->getSession()->write('categoria_id', 1);
$session = $this->request->getSession();
//$session->write('categoria_id', 1);
// echo $this->request->getSession()->read('categoria_id');
// die();
?>

<div class="row justify-content-center">
    <div class="col-auto">
        <?php if ($session->read('categoria_id') == 1): ?>
            <?= $this->Form->create($estagiarios, ['class' => 'form-inline']); ?>
			<?= $this->Form->input('periodo', [
					'id' => 'EstagiarioPeriodo', 
					'type' => 'select', 
					'label' => ['text' => 'Período ', 'style' => 'display: inline;'], 
					'options' => $periodos, 
					'selected' => $periodo, 
					'class' => 'form-control'
				]); 
			?>
            <?= $this->Form->end(); ?>
        <?php else: ?>
            <h1 style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?= '2020-1'; ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="estagiarios index content">
    <?= $this->Html->link(__('Novo Estagiario'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Estagiarios') ?></h3>
    <div>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('Alunos.nome', 'Aluno') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('ajustecurricular2020') ?></th>
                    <th><?= $this->Paginator->sort('turno') ?></th>
                    <th><?= $this->Paginator->sort('nivel') ?></th>
                    <th><?= $this->Paginator->sort('tc') ?></th>
                    <th><?= $this->Paginator->sort('tc_solicitacao') ?></th>
                    <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituicao') ?></th>
                    <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor') ?></th>
                    <th><?= $this->Paginator->sort('Profesdsores.nome', 'Professor') ?></th>
                    <th><?= $this->Paginator->sort('periodo') ?></th>
                    <th><?= $this->Paginator->sort('Areaestagios.nome', 'Area estagio') ?></th>
                    <th><?= $this->Paginator->sort('nota') ?></th>
                    <th><?= $this->Paginator->sort('ch') ?></th>
                    <th><?= $this->Paginator->sort('observacoes') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estagiarios as $estagiario): ?>
                <tr>
                    <td><?= $this->Number->format($estagiario->id) ?></td>
                    <td><?= $estagiario->aluno ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?></td>
                    <td><?= $estagiario->registro ?></td>
                    <td><?= h($estagiario->ajustecurricular2020) ?></td>
                    <td><?= h($estagiario->turno) ?></td>
                    <td><?= h($estagiario->nivel) ?></td>
                    <td><?= $estagiario->tc ?></td>
                    <td><?= h($estagiario->tc_solicitacao) ?></td>
                    <td><?= $estagiario->instituicao ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicao', 'action' => 'view', $estagiario->instituicao->id]) : '' ?></td>
                    <td><?= ($estagiario->supervisor and $estagiario->supervisor->nome) ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : 'Sem supervisor' ?></td>
                    <td><?= $estagiario->professor ? $this->Html->link($estagiario->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?></td>
                    <td><?= h($estagiario->periodo) ?></td>
                    <td><?= $estagiario->areaestagio ? $this->Html->link($estagiario->areaestagio->area, ['controller' => 'Areaestagios', 'action' => 'view', $estagiario->areaestagio->id]) : '' ?></td>
                    <td><?= $estagiario->nota ? $this->Number->format($estagiario->nota) : '' ?></td>
                    <td><?= $estagiario->ch ? $this->Number->format($estagiario->ch) : '' ?></td>
                    <td><?= h($estagiario->observacoes) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $estagiario->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estagiario->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiario->id)]) ?>
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
