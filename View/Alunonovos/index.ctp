<?= $this->element('submenu_alunonovos') ?>

<div class='row justify-content-center'>
    <h1>Alunos novos</h1>
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

<div class='row justify-content-center'>
    <div class="col-auto">
        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th>DRE</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunonovo as $c_aluno): ?>
                    <?php if ($c_aluno['Alunonovo']['id']) {
                        ;
                        ?>
                        <tr>
                            <td style='text-align:center'>
        <?php echo $this->Html->link($c_aluno['Alunonovo']['registro'], '/Alunonovos/view/' . $c_aluno['Alunonovo']['id']); ?>
                            <td style='text-align:left'><?php echo $c_aluno['Alunonovo']['nome']; ?></td>
                            <td style='text-align:left'><?php echo $c_aluno['Alunonovo']['email']; ?></td>
                        </tr>
                    <?php }; ?>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
