<?= $this->element('submenu_alunonovos') ?>

<div class='row justify-content-center'>
    <h1>Estudantes</h1>
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
                    <th><?= $this->Paginator->sort('registro', 'DRE') ?></th>
                    <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                    <?php if ($this->Session->read('id_categoria') != '2'): ?>
                        <th><?= $this->Paginator->sort('nascimento', 'Nascimento') ?></th>
                        <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                    <?php endif; ?>
                    <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>

                    <?php if ($this->Session->read('id_categoria') != '2'): ?>
                        <th><?= $this->Paginator->sort('telefone', 'Telefone') ?></th>
                        <th><?= $this->Paginator->sort('celular', 'Celular') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunonovo as $c_aluno): ?>
                    <?php
                    if ($c_aluno['Alunonovo']['id']) {
                        ;
                        ?>
                        <tr>
                            <td style='text-align:center'>
                                <?php if ($this->Session->read('id_categoria') == '2'): ?>
                                    <?php echo $c_aluno['Alunonovo']['registro']; ?>
                                <?php else: ?>
                                    <?php echo $this->Html->link($c_aluno['Alunonovo']['registro'], '/Alunonovos/view/' . $c_aluno['Alunonovo']['id']); ?>                                
                                <?php endif; ?>
                            </td>
                            <td style='text-align:left'><?php echo $c_aluno['Alunonovo']['nome']; ?></td>
                            <?php if ($this->Session->read('id_categoria') != '2'): ?>
                                <td style='text-align:left'><?php echo $c_aluno['Alunonovo']['nascimento']; ?></td>
                                <td style='text-align:left'><?php echo $c_aluno['Alunonovo']['cpf']; ?></td>
                            <?php endif; ?>
                            <td style='text-align:left'><?php echo $c_aluno['Alunonovo']['email']; ?></td>
                            <?php if ($this->Session->read('id_categoria') != '2'): ?>
                                <td style='text-align:left'><?php echo $c_aluno['Alunonovo']['telefone']; ?></td>
                                <td style='text-align:left'><?php echo $c_aluno['Alunonovo']['celular']; ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php }; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
