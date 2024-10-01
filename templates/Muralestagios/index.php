<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio[]|\Cake\Collection\CollectionInterface $muralestagios
 */
// pr($muralestagios);
// pr($periodo);
?>

<script type="text/javascript">
	$(document).ready(function () {
        var url = "<?= $this->Html->Url->build(['controller' => 'muralestagios']); ?>";
        var select = $("#muralestagioperiodo");
		var pathname = location.pathname.split('/').filter(Boolean);
		if (pathname[pathname.length - 2] == 'index') select.val(pathname[pathname.length - 1]);
		select.on('change', function () {
            var periodo = $(this).val();
            window.location = url + '/index/' + periodo;
        });
    });
</script>

<?php
$session = $this->request->getSession();
$session->write('categoria_id', 1);
//echo $session->read('categoria_id');
?>

<div class="muralestagios index content">
	
	<div class="row justify-content-center">
	    <div class="col-auto">
	        <?php if ($session->read('categoria_id') == 1): ?>
	            <?= $this->Form->create($muralestagios, ['class' => 'form-inline']); ?>
					<?= $this->Form->label('muralestagioperiodo', 'Período'); ?>
					<?= $this->Form->input('periodo', [
							'default'=> $periodo->periodo,
							'id' => 'muralestagioperiodo', 
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
		    <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'button']) ?>
		</div>
	</aside>
	
	<h3><?= __('Mural de estagios') ?></h3>
	
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <th class="actions"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('vagas') ?></th>
                    <th><?= $this->Paginator->sort('professor') ?></th>
                    <th><?= $this->Paginator->sort('beneficios') ?></th>
                    <th><?= $this->Paginator->sort('final_de_semana', 'Final de semana') ?></th>
                    <th><?= $this->Paginator->sort('cargaHoraria', 'CH') ?></th>
                    <th><?= $this->Paginator->sort('dataSelecao', 'Seleção') ?></th>
                    <th><?= $this->Paginator->sort('dataInscricao', 'Inscrição') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($muralestagios as $muralestagio): ?>
                    <tr>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $muralestagio->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralestagio->id]) ?>
                            <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagio->id)]) ?>
                        </td>
                        <td><?= h($muralestagio->id) ?></td>
                        <td><?= $muralestagio->instituicao ? $this->Html->link($muralestagio->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $muralestagio->instituicao->id]) : '' ?></td>
                        <td><?= h($muralestagio->vagas) ?></td>
						<td><?= $muralestagio->professor ? $this->Html->link($muralestagio->professor->nome, ['controller' => 'Professores', 'action' => 'view', $muralestagio->professor->id]) : '' ?></td>
                        <td><?= h($muralestagio->beneficios) ?></td>
                        <td><?= h($muralestagio->final_de_semana) ?></td>
                        <td><?= h($muralestagio->cargaHoraria) ?></td>
                        <td><?= h($muralestagio->dataSelecao) ?></td>
                        <td><?= h($muralestagio->dataInscricao) ?></td>
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
