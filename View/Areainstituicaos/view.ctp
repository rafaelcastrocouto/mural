<?= $this->element('submenu_areainstituicoes') ?>

<h1>Áreas das instituições</h1>

<?php echo $this->Html->link($area['Areainstituicao']['id'], '/Instituicaos/index/area_instituicoes_id:' . $area['Areainstituicao']['id']); ?>
<?php echo ' | '; ?>
<?php echo $this->Html->link($area['Areainstituicao']['area'], '/Instituicaos/index/area_instituicoes_id:' . $area['Areainstituicao']['id']); ?>

