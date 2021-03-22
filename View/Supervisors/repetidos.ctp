<?php // pr($repetidos);    ?>

<div class='table-responsive'>

    <?= $this->element('submenu_supervisores') ?>

    <?php if ($repetidos): ?>
        <div class='row justify-content-center'>
            <div class='col-auto'>

                <table class="table table-hover table-striped table-responsive">
                    <caption style="caption-side: top">CRESS repetidos</caption>
                    <?php foreach ($repetidos as $c_repetidos): ?>
                        <tr>
                            <td><?php echo $c_repetidos['Supervisor']['cress']; ?></td>
                            <td><?php echo $this->Html->link($c_repetidos['Supervisor']['nome'], '/supervisors/view/' . $c_repetidos['Supervisor']['id']); ?></td>
                            <td><?php echo $c_repetidos['0']['quantidade']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

    <?php endif; ?>
</div>