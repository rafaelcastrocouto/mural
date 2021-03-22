<div class="container">
    <div class='row justify-content-left'>
        <div class='col-auto'>

    <?= $this->element('submenu_extensaos') ?>

            <h2><?php echo __('Coordenadores'); ?></h2>
            <table class='table table-striped table-hover table-responsive'>
                <thead>
                    <tr>
                        <th><?php echo $this->Html->link('Id', ['action' => 'coordenadores?ordem=id']); ?></th>
                        <th><?php echo $this->Html->link('Nome', ['action' => 'coordenadores?ordem=nome']); ?></th>
                        <th><?php echo $this->Html->link('Segmento', ['action' => 'coordenadores?ordem=segmento']); ?></th>
                        <th><?php echo $this->Html->link('Título', ['action' => 'coordenadores?ordem=titulo']); ?></th>
                        <th><?php echo $this->Html->link('Data', ['action' => 'coordenadores?ordem=datacongregacao']); ?></th>
                        <th><?php echo $this->Html->link('Observações', ['action' => 'coordenadores?ordem=observacoes']); ?></th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($lista as $extensao): ?>
                <?php // pr($extensao); ?>
                <?php // die('extensao'); ?>
                    <tr>
                        <td><?php echo h($extensao['extensao_id']); ?>&nbsp;</td>
                    <?php if ($extensao['segmento'] === 'docente'): ?>
                        <td>
                          <?php echo $this->Html->link($extensao['nome'], array('controller' => 'professors', 'action' => 'view', $extensao['docente_id'])); ?>
                        </td>
                    <?php elseif ($extensao['segmento'] === 'tae'): ?>
                        <td>
                        <?php echo $this->Html->link($extensao['nome'], array('controller' => 'taes', 'action' => 'view', $extensao['tae_id'])); ?>
                        </td>
                    <?php endif; ?>
                        <td><?php echo $extensao['segmento']; ?></td>
                        <td><?php echo $this->Html->link(h($extensao['titulo']), ['controll' => 'extensaos', 'action' => 'view', $extensao['extensao_id']]); ?>&nbsp;</td>
                        <td><?php echo h($extensao['datacongregacao']); ?>&nbsp;</td>
                        <td><?php echo h($extensao['observacoes']); ?>&nbsp;</td>
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
        </div>
    </div>
</div>
