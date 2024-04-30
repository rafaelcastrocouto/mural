<?= $this->element('submenu_alunonovos') ?>

<div class='row justify-content-center'>
    <h1>Estudantes</h1>
</div>

<div class='pagination justify-content-center'>
    <?= $this->Paginator->first('<< Primeiro ', ['class' => 'page-link']) ?>
    <?= $this->Paginator->prev('< Anterior ', ['class' => 'page-link'], null, []) ?>
    <?= $this->Paginator->next(' Posterior > ', ['class' => 'page-link'], null, []) ?>
    <?= $this->Paginator->last(' Último >> ', ['class' => 'page-link']) ?>
</div>

<div class="pagination justify-content-center">
    <?= $this->Paginator->numbers(['separator' => false, 'class' => 'page-link']) ?>
</div>

<div class='table-responsive'>
    <table class='table table-hover table-striped table-responsive'>
        <thead class='thead-light'>
            <tr>
                <th>
                    <?= $this->Paginator->sort('registro', 'DRE') ?>
                </th>
                <th>
                    <?= $this->Paginator->sort('nome', 'Nome') ?>
                </th>
                <?php if ($this->Session->read('id_categoria') != '2'): ?>
                    <th>
                        <?= $this->Paginator->sort('nascimento', 'Nascimento') ?>
                    </th>
                    <th>
                        <?= $this->Paginator->sort('cpf', 'CPF') ?>
                    </th>
                <?php endif; ?>
                <th>
                    <?= $this->Paginator->sort('email', 'E-mail') ?>
                </th>

                <?php if ($this->Session->read('id_categoria') != '2'): ?>
                    <th>
                        <?= $this->Paginator->sort('telefone', 'Telefone') ?>
                    </th>
                    <th>
                        <?= $this->Paginator->sort('celular', 'Celular') ?>
                    </th>
                <?php endif; ?>
                <th><?= $this->Paginator->sort('ingresso', 'Ingresso') ?></th>
                <th><?= $this->Paginator->sort('inscricao_count', 'Inscrições') ?></th>
                <th><?= $this->Paginator->sort('estagiario_count', 'Estágios') ?></th>
            </tr>
        </thead>
            <tbody>
            <?php foreach ($alunonovo as $c_aluno): ?>
                <?php
                if ($c_aluno['Alunonovo']['id']) {
                    ?>
                    <tr>
                        <td style='text-align:center'>
                            <?php if ($this->Session->read('id_categoria') == '2'): ?>
                                <?php echo $c_aluno['Alunonovo']['registro']; ?>
                            <?php else: ?>
                                <?php echo $this->Html->link($c_aluno['Alunonovo']['registro'], '/Alunonovos/view/' . $c_aluno['Alunonovo']['id']); ?>
                            <?php endif; ?>
                        </td>
                        <td style='text-align:left'>
                            <?php echo $c_aluno['Alunonovo']['nome']; ?>
                        </td>
                        <?php if ($this->Session->read('id_categoria') != '2'): ?>
                            <td style='text-align:left'>
                                <?php echo $c_aluno['Alunonovo']['nascimento']; ?>
                            </td>
                            <td style='text-align:left'>
                                <?php echo $c_aluno['Alunonovo']['cpf']; ?>
                            </td>
                        <?php endif; ?>
                        <td style='text-align:left'>
                            <?php echo $c_aluno['Alunonovo']['email']; ?>
                        </td>
                        <?php if ($this->Session->read('id_categoria') != '2'): ?>
                            <td style='text-align:left'>
                                <?php echo $c_aluno['Alunonovo']['telefone']; ?>
                            </td>
                            <td style='text-align:left'>
                                <?php echo $c_aluno['Alunonovo']['celular']; ?>
                            </td>
                        <?php endif; ?>
                        <td class='text-center'>
                            <?php echo $c_aluno['Alunonovo']['ingresso'] ?>
                        </td>      
                        <td class='text-center'>
                            <?php echo $c_aluno['Alunonovo']['inscricao_count'] ?>
                        </td>
                        <td class='text-center'>
                            <?php echo $c_aluno['Alunonovo']['estagiario_count'] ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class='pagination justify-content-right'>
<?php
echo $this->Paginator->counter(array(
    'format' => 'Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
));
?>
</div>