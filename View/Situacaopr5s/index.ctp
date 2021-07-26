<?= $this->element('submenu_extensaos') ?>
<h2><?php echo __('Situações PR5'); ?></h2>
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('id', 'Id'); ?></th>
            <th><?php echo $this->Paginator->sort('situacao', 'Situação'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($situacaopr5s as $situacaopr5): ?>
            <tr>
                <td><?php echo h($situacaopr5['Situacaopr5']['id']); ?>&nbsp;</td>
                <td><?php echo h($situacaopr5['Situacaopr5']['situacao']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $situacaopr5['Situacaopr5']['id'])); ?>
                    <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $situacaopr5['Situacaopr5']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Excluir'), array('action' => 'delete', $situacaopr5['Situacaopr5']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $situacaopr5['Situacaopr5']['id']))); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>	</p>
<div class="paging">
    <?php
    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Inserir nova situação PR5'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('Listar projetos de extensão'), array('controller' => 'extensaos', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('Inserir novo projeto de extensão'), array('controller' => 'extensaos', 'action' => 'add')); ?> </li>
    </ul>
</div>
