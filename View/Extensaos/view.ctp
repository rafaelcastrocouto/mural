<div class="table-responsive">

    <?= $this->element('submenu_extensaos'); ?>

    <h2><?php echo __('Extensão'); ?></h2>
    <dl class='row'>
        <dt class='col-3'><?php echo __('Id'); ?></dt>
        <dd class='col-9'>
            <?php echo h($extensao['Extensao']['id']); ?>
            &nbsp;
        </dd>
        <dt class='col-3'><?php echo __('Titulo'); ?></dt>
        <dd class='col-9'>
            <?php echo h($extensao['Extensao']['titulo']); ?>
            &nbsp;
        </dd>
        <dt class="col-3"><?php echo __('Coordenação'); ?></dt>
        <dd class="col-9">
            <?php if ($extensao['Extensao']['segmento'] === 'tae'): ?>
                <?php echo $this->Html->link($extensao['Extensao']['nome'], array('controller' => 'taes', 'action' => 'view', $extensao['Tae']['id'])); ?>
            &nbsp;
            <?php elseif ($extensao['Extensao']['segmento'] === 'docente'): ?>
                <?php echo $this->Html->link($extensao['Extensao']['nome'], array('controller' => 'professors', 'action' => 'view', $extensao['Professor']['id'])); ?>
            &nbsp;
            <?php endif; ?>
        </dd>

        <dt class="col-3"><?php echo __('Data aprovação na congregação'); ?></dt>
        <dd class='col-9'>
            <?php if($extensao['Extensao']['datacongregacao']): 
            echo date('d-m-Y', strtotime($extensao['Extensao']['datacongregacao']));
            endif;
            ?>
            &nbsp;
        </dd>
        <dt class="col-3"><?php echo __('Versão'); ?></dt>
        <dd class="col-9">
            <?php echo h($extensao['Extensao']['versao']); ?>
            &nbsp;
        </dd>
        <dt class="col-3"><?php echo __('Situação'); ?></dt>
        <dd class="col-9">
            <?php echo h($extensao['Situacaopr5']['situacao']); ?>
            &nbsp;
        </dd>        
        <dt class="col-3"><?php echo __('Observações'); ?></dt>
        <dd class="col-9">
            <?php echo h($extensao['Extensao']['observacoes']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
