<?php
/* pr($areas); */
?>

<div class='table-responsive'>
    <?= $this->element('submenu_areas') ?>

    <h1>Áreas de orientação dos professores de OTP</h1>

    <div class='pagination justify-content-center'>
        <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
        <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
        <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
        <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
    </div>

    <div class="pagination justify-content-center">
        <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
    </div>

<div class='row justify-content-center'>
<div class='col-auto'>
    <table class='table table-hover table-striped table-responsive'>

        <?php foreach ($areas as $c_area): ?>

            <tr>
                <td>
                    <?php echo $this->Html->link($c_area['Area']['id'], '/Areas/view/' . $c_area['Area']['id']); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($c_area['Area']['area'], '/Areas/view/' . $c_area['Area']['id']); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($c_area['Professor']['nome'], '/Professors/view/' . $c_area['Professor']['id']); ?>
                </td>
                <td>
                    <?php echo $c_area['Professor']['departamento']; ?>
                </td>
                <td>
                    <?php echo $c_area['Area']['virtualMinPeriodo']; ?>
                </td>
                <td>
                    <?php echo $c_area['Area']['virtualMaxPeriodo']; ?>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>
  </div>
</div>
</div>
