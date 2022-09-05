<div class='row justify-content-left'>
    <div class='col-auto'>
        <?= $this->element('submenu_complementos') ?>
    </div>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <h2><?php echo __('Modalidade período especial'); ?></h2>

        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('periodo_especial', "Modalidade período especial"); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complementos as $complemento): ?>
                    <tr>
                        <td><?php echo $this->Html->link(h($complemento['Complemento']['id']), ['action' => 'view', $complemento['Complemento']['id']]); ?>&nbsp;</td>
                        <td><?php echo h($complemento['Complemento']['periodo_especial']); ?>&nbsp;</td>
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
            echo $this->Paginator->numbers(array('separator' => '&nbsp;'));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
    </div>
</div>

