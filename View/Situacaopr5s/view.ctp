<div class="situacaopr5s view">
<h2><?php echo __('Situação PR5'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($situacaopr5['Situacaopr5']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Situacao'); ?></dt>
		<dd>
			<?php echo h($situacaopr5['Situacaopr5']['situacao']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar situação PR5'), array('action' => 'edit', $situacaopr5['Situacaopr5']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Excluir situação PR5'), array('action' => 'delete', $situacaopr5['Situacaopr5']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $situacaopr5['Situacaopr5']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('Listar situações PR5'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Inserir nova situação PR5'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar projetos de extensão'), array('controller' => 'extensaos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Inserir projetor de extensão'), array('controller' => 'extensaos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Extensaos'); ?></h3>
	<?php if (!empty($situacaopr5['Extensao'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Titulo'); ?></th>
		<th><?php echo __('Docente'); ?></th>
		<th><?php echo __('Tae'); ?></th>
		<th><?php echo __('Segmento'); ?></th>
		<th><?php echo __('Segmento Id'); ?></th>
		<th><?php echo __('Nome'); ?></th>
		<th><?php echo __('Data da congregação'); ?></th>
		<th><?php echo __('Situação PR5'); ?></th>
		<th><?php echo __('Situação'); ?></th>
		<th><?php echo __('Versão'); ?></th>
		<th><?php echo __('Observações'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($situacaopr5['Extensao'] as $extensao): ?>
		<tr>
			<td><?php echo $extensao['id']; ?></td>
			<td><?php echo $extensao['titulo']; ?></td>
			<td><?php echo $extensao['docente_id']; ?></td>
			<td><?php echo $extensao['tae_id']; ?></td>
			<td><?php echo $extensao['segmento']; ?></td>
			<td><?php echo $extensao['segmento_id']; ?></td>
			<td><?php echo $extensao['nome']; ?></td>
			<td><?php echo $extensao['datacongregacao']; ?></td>
			<td><?php echo $extensao['situacaopr5_id']; ?></td>
			<td><?php echo $extensao['situacao']; ?></td>
			<td><?php echo $extensao['versao']; ?></td>
			<td><?php echo $extensao['observacoes']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'extensaos', 'action' => 'view', $extensao['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'extensaos', 'action' => 'edit', $extensao['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'extensaos', 'action' => 'delete', $extensao['id']), array('confirm' => __('Are you sure you want to delete # %s?', $extensao['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Novo projeto de extensão'), array('controller' => 'extensaos', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
