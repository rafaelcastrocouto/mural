<div class="row justify-content-center">
    <div class="col-auto">

        <?= $this->element('submenu_folhadeatividades') ?>

        <h2><?php echo __('Folha de atividades'); ?></h2>
        <table class='table table-hover table-striped table-responsive'>
            <thead class="thead-light">
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('estagiario_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('dia'); ?></th>
                    <th><?php echo $this->Paginator->sort('horario', 'Horas'); ?></th>
                    <th><?php echo $this->Paginator->sort('atividade'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($folhadeatividades as $folhadeatividade): ?>
                    <tr>
                        <td><?php echo h($folhadeatividade['Folhadeatividade']['id']); ?>&nbsp;</td>
                        <td>
                            <?php echo $this->Html->link($folhadeatividade['Estagiario']['Aluno']['nome'], array('controller' => 'estagiarios', 'action' => 'view', $folhadeatividade['Estagiario']['id'])); ?>
                        </td>
                        <td><?php echo date('d-m-Y', strtotime($folhadeatividade['Folhadeatividade']['dia'])); ?>&nbsp;</td>
                        <td><?php echo h($folhadeatividade['Folhadeatividade']['horario']); ?>&nbsp;</td>
                        <td><?php echo h($folhadeatividade['Folhadeatividade']['atividade']); ?>&nbsp;</td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('View'), array('action' => 'view', $folhadeatividade['Folhadeatividade']['id'])); ?>
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $folhadeatividade['Folhadeatividade']['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $folhadeatividade['Folhadeatividade']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $folhadeatividade['Folhadeatividade']['id']))); ?>
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
        <div class="pagination justify-content-center">
            <?php
            echo $this->Paginator->prev('< ' . __('previous'), array('class' => 'page-link'), null, array());
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array('class' => 'page-link'), null, array());
            ?>
        </div>
    </div>
</div>
