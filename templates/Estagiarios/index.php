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
        var select= $("#estagiarioperiodo");
		var pathname = location.pathname.split('/').filter(Boolean);
		if (pathname[pathname.length - 2] == 'index') select.val(pathname[pathname.length - 1]);
        select.change(function () {
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


<div class="estagiarios index content">
	
	<div class="row justify-content-center">
	    <div class="col-auto">
	        <?php if ($session->read('categoria_id') == 1): ?>
	            <?= $this->Form->create($estagiarios, ['class' => 'form-inline']); ?>
					<?= $this->Form->label('estagiarioperiodo', 'Período'); ?>
					<?= $this->Form->input('periodo', [
							'default'=> $periodo->periodo,
							'id' => 'estagiarioperiodo', 
							'type' => 'select', 
							'options' => $periodos, 
							'class' => 'form-control'
						]); 
					?>
	            <?= $this->Form->end(); ?>
	        <?php else: ?>
	            <h1 style="text-align: center;">Período: <?= '2005-1'; ?></h1>
	        <?php endif; ?>
	    </div>
	</div>
	
	<aside>
		<div class="nav">
		    <?= $this->Html->link(__('Novo Estagiario'), ['action' => 'add'], ['class' => 'button']) ?>
		</div>
	</aside>
	
    <h3><?= __('Lista de Estagiarios') ?></h3>
	
	<div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('Alunos.nome', 'Aluno') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('turno') ?></th>
                    <th><?= $this->Paginator->sort('nivel') ?></th>
                    <th><?= $this->Paginator->sort('tc') ?></th>
                    <th><?= $this->Paginator->sort('tc_solicitacao') ?></th>
                    <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituicao') ?></th>
                    <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor') ?></th>
                    <th><?= $this->Paginator->sort('Professores.nome', 'Professor') ?></th>
                    <th><?= $this->Paginator->sort('periodo') ?></th>
                    <th><?= $this->Paginator->sort('Turmaestagios.turma', 'Turma') ?></th>
                    <th><?= $this->Paginator->sort('nota') ?></th>
                    <th><?= $this->Paginator->sort('ch') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estagiarios as $estagiario): ?>
                <tr>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $estagiario->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estagiario->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Are you sure you want to delete estagiario #{0}?', $estagiario->id)]) ?>
                    </td>
                    <td><?= $this->Html->link($estagiario->id, ['action' => 'view', $estagiario->id]) ?></td>
                    <td><?= $estagiario->aluno ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?></td>
                    <td><?= h($estagiario->registro) ?></td>
                    <td>
						<?php
                        $turno = '';
						switch ( $estagiario->turno ) {
							case 'D': $turno = 'Diurno';   break;
							case 'N': $turno = 'Noturno';  break;
							case 'A': $turno = 'Ambos';    break;
		                    case 'I': $turno = 'Integral'; break;
						}
						echo h($turno);
						?>
					</td>
                    <td><?= h($estagiario->nivel) ?></td>
                    <td><?= h($estagiario->tc) ?></td>
                    <td><?= h($estagiario->tc_solicitacao) ?></td>
                    <td><?= $estagiario->instituicao ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?></td>
                    <td><?= ($estagiario->supervisor and $estagiario->supervisor->nome) ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?></td>
                    <td><?= $estagiario->professor ? $this->Html->link($estagiario->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?></td>
                    <td><?= h($estagiario->periodo) ?></td>
                    <td><?= $estagiario->turmaestagio ? $this->Html->link($estagiario->turmaestagio->turma, ['controller' => 'Turmaestagios', 'action' => 'view', $estagiario->turmaestagio->id]) : '' ?></td>
                    <td><?= $estagiario->nota ? $this->Number->format($estagiario->nota) : '' ?></td>
                    <td><?= $estagiario->ch ? $this->Number->format($estagiario->ch) : '' ?></td>
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
