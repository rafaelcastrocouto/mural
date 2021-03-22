<div class='row justify-content-left'>
    <div class='col-auto'>
        <?= $this->element('submenu_supervisores') ?>
    </div>
</div>

<?php if (isset($supervisores)): ?>
    <div class='row justify-content-center'>
        <div class='col-auto'>
            <h1>Resultado da busca por supervisores</h1>

            <div class='pagination justify-content-center'>

                <?php $this->Paginator->options(array('url' => array($busca))); ?>

                <?php echo $this->Paginator->prev('<< Anterior ', ['class' => 'page-link']); ?>
                <?php echo $this->Paginator->next(' Posterior >> ', ['class' => 'page-link']); ?>
            </div>
            <div class='pagination justify-content-center'>
                <?php echo $this->Paginator->numbers(['separator' => false, 'class' => 'page-link']); ?>
            </div>
        </div>
    </div>

    <div class='row justify-content-center'>
        <div class='col-auto'>
            <div class='table-responsive'>
                <table class='table table-hover table-striped table-responsive'>
                    <?php foreach ($supervisores as $c_supervisor): ?>
                        <tr>
                            <td><?php echo $this->Html->link($c_supervisor['Supervisor']['nome'], '/Supervisors/view/' . $c_supervisor['Supervisor']['id']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

<?php else: ?>

    <div class='row justify-content-left'>
        <div class="col-auto">
            <h1>Busca supervisores</h1>

            <?php echo $this->Form->create('Supervisor'); ?>
            <?php echo $this->Form->input('nome', array('label' => 'Digite o nome do supervisor', 'class' => 'form-control')); ?>
            <div class='row justify-content-left'>
                <div class='col-auto'>
                    <?php
                    echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
                    ?>
                    <?php
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
