<?php // pr($semalunos); ?>

<?= $this->element('submenu_supervisores') ?>

<div class='row justify-content-center'>
    <div class="col-auto">

        <h1>Supervisores(as) sem estagiários</h1>

        <div class='pagination justify-content-center'>
            <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
            <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
        </div>

        <div class="pagination justify-content-center">
            <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
        </div>

        <table class="table table-hover table-striped table-responsive">
            <caption>Supervisores sem estagiários</caption>
            <thead class="thead-light">
                <tr>
                    <th><?= $this->Paginator->sort('id','Id') ?></th>
                    <th><?= $this->Paginator->sort('cress', 'CRESS') ?></th>
                    <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($semalunos as $c_semalunos): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $c_semalunos['Supervisor']['cress']; ?></td>
                        <td><?php echo $this->Html->link($c_semalunos['Supervisor']['nome'], '/supervisors/view/' . $c_semalunos['Supervisor']['id']); ?></td>
                        <td><?php
                            if (!empty($c_semalunos['Instituicao']['0']['instituicao'])):
                                echo $c_semalunos['Instituicao']['0']['instituicao'];
                            endif;
                            ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
