<?php
/* pr($areas); */
?>

<div class="row justify-content-left">
    <div class="col-auto">
        <?= $this->element('submenu_areas') ?>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-auto">
        <h1>Áreas de orientação dos professores de OTP</h1>
    </div>
</div>

<div class='pagination justify-content-center'>
    <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
    <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
</div>

<div class="pagination justify-content-center">
    <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
</div>

<div class="row justify-content-center">
    <div class="col-auto">
        <table class='table table-hover table-striped table-responsive'>

            <?php foreach ($areas as $c_area): ?>

                <tr>
                    <td>
                        <?php echo $this->Html->link($c_area['Area']['id'], '/Areas/view/' . $c_area['Area']['id']); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($c_area['Area']['area'], '/Estagiarios/index/id_area:' . $c_area['Area']['id']); ?>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>
    </div>
</div>