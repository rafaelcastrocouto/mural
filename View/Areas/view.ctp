<div class='table-responsive'>
    <?= $this->element('submenu_areas') ?>
    <h1>Área</h1>

    <?php echo $this->Html->link($area['Area']['id'], '/Estagiarios/index/id_area:' . $area['Area']['id']); ?>
    <?php echo ' | '; ?>
    <?php echo $this->Html->link($area['Area']['area'], '/Estagiarios/index/id_area:' . $area['Area']['id'] . '/periodo:0'); ?>

</div>