<?=

$this->element("submenu_taes") ?>

<div class='table-responsive'>

<div class="row justify-content-center">
  <div class='col-auto'>

      <h2><?php echo __('Taes'); ?></h2>
      <table class='table table-hover table-striped table-responsive'>
          <thead class='thead-light'>
              <tr>
                  <th><?php echo $this->Paginator->sort('id'); ?></th>
                  <th><?php echo $this->Paginator->sort('siape'); ?></th>
                  <th><?php echo $this->Paginator->sort('nome'); ?></th>
              </tr>
          </thead>
          <tbody>
  	<?php foreach ($taes as $tae): ?>
              <tr>
                  <td><?php echo h($tae['Tae']['id']); ?>&nbsp;</td>
                  <td><?php echo h($tae['Tae']['siape']); ?>&nbsp;</td>
                  <td><?php echo $this->Html->link(h($tae['Tae']['nome']), ['controller' => 'taes', 'action' => 'view', $tae['Tae']['id']]); ?>&nbsp;</td>
              </tr>
  <?php endforeach; ?>
          </tbody>
      </table>
  </div>
</div>

    <p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
    <div class="pagination justify-content-center">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'page-link'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'page-link'));
	?>
    </div>
</div>
