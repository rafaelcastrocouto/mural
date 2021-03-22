<?= $this->element('submenu_taes') ?>

<h2><?php echo __('Tae'); ?></h2>

<dl class='row'>
    <dt class="col-1"><?php echo __('Id'); ?></dt>
    <dd class="col-11">
        <?php echo h($tae['Tae']['id']); ?>
        &nbsp;
    </dd>
    
    <dt class="col-1"><?php echo __('Siape'); ?></dt>
    <dd class='col-11'>
        <?php echo h($tae['Tae']['siape']); ?>
        &nbsp;
    </dd>
    
    <dt class="col-1"><?php echo __('Nome'); ?></dt>
    <dd class='col-11'>
        <?php echo h($tae['Tae']['nome']); ?>
        &nbsp;
    </dd>
</dl>

<div class="table-reponsive">

    <h3><?php echo __('Projetos de Extensão'); ?></h3>
    <?php if (!empty($tae['Extensao'])): ?>
        <table class='table table-hover table-striped table-responsive'>
            <thead class="thead-light">
                <tr>
                    <th><?php echo __('Id'); ?></th>
                    <th><?php echo __('Titulo'); ?></th>
                    <th><?php echo __('Nome'); ?></th>
                    <th><?php echo __('Congregação'); ?></th>
                    <th><?php echo __('Observações'); ?></th>
                </tr>
            </thead>
            <?php foreach ($tae['Extensao'] as $extensao): ?>
                <tr>
                    <td><?php echo $extensao['id']; ?></td>
                    <td><?php echo $this->Html->link($extensao['titulo'], ['controller' => 'extensaos', 'action' => 'view', $extensao['id']]); ?></td>
                    <td><?php echo $extensao['nome']; ?></td>
                    <td><?php echo $extensao['datacongregacao']; ?></td>
                    <td><?php echo $extensao['observacoes']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</div>
