<?= $this->element('submenu_complementos'); ?>

<h2><?php echo __('Complemento de período especial'); ?></h2>
<dl>
	<dt><?php echo __('Id'); ?></dt>
	<dd>
		<?php echo h($complemento['Complemento']['id']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Periodo Especial'); ?></dt>
	<dd>
		<?php echo h($complemento['Complemento']['periodo_especial']); ?>
		&nbsp;
	</dd>
</dl>
