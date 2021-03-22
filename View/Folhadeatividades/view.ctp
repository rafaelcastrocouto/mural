<div class="row justify-content-center">
    <div class="col-auto">

        <?= $this->element('submenu_folhadeatividades') ?>

        <h2><?php echo __('Folha de atividades'); ?></h2>
        <dl class='row'>
            <dt class='col-3'><?php echo __('Id'); ?></dt>
            <dd class='col-9'>
                <?php echo h($folhadeatividade['Folhadeatividade']['id']); ?>
                &nbsp;
            </dd>
            <dt class='col-3'><?php echo __('Estagiario'); ?></dt>
            <dd class='col-9'>
                <?php echo $this->Html->link($estudante['Aluno']['nome'], array('controller' => 'estagiarios', 'action' => 'view', $folhadeatividade['Folhadeatividade']['estagiario_id'])); ?>
                &nbsp;
            </dd>
            <dt class='col-3'><?php echo __('Dia'); ?></dt>
            <dd class='col-9'>
                <?php echo date('d-m-Y', strtotime($folhadeatividade['Folhadeatividade']['dia'])); ?>
                &nbsp;
            </dd>

            <dt class='col-3'><?php echo __('Início'); ?></dt>
            <dd class='col-9'>
                <?php echo h($folhadeatividade['Folhadeatividade']['inicio']); ?>
                &nbsp;
            </dd>

            <dt class='col-3'><?php echo __('Final'); ?></dt>
            <dd class='col-9'>
                <?php echo h($folhadeatividade['Folhadeatividade']['final']); ?>
                &nbsp;
            </dd>

            <dt class='col-3'><?php echo __('Horas'); ?></dt>
            <dd class='col-9'>
                <?php echo h($folhadeatividade['Folhadeatividade']['horario']); ?>
                &nbsp;
            </dd>
            <dt class='col-3'><?php echo __('Atividade'); ?></dt>
            <dd class='col-9'>
                <?php echo h($folhadeatividade['Folhadeatividade']['atividade']); ?>
                &nbsp;
            </dd>
        </dl>
    </div>
</div>
