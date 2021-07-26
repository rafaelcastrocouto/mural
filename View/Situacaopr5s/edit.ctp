<div class="situacaopr5s form">
<?php echo $this->Form->create('Situacaopr5'); ?>
	<fieldset>
		<legend><?php echo __('Edit Situacaopr5'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('situacao');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Situacaopr5.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Situacaopr5.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Situacaopr5s'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Extensaos'), array('controller' => 'extensaos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Extensao'), array('controller' => 'extensaos', 'action' => 'add')); ?> </li>
	</ul>
</div>
