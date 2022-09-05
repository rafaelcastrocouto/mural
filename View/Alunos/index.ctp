<?php
// pr($alunos);
?>

<div class='table-responsive'>
    <?= $this->element('submenu_alunos'); ?>

    <div class='row justify-content-center'>
        <h1>Estagiários</h1>
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
</div>

<table class='table table-hover table-striped table-reponsive'>
    <tr>

        <?php if ($this->Session->read('categoria') != 'estudante'): ?>
            <th><?php echo $this->Paginator->sort('registro', 'Registro'); ?></th>
        <?php endif; ?>

        <th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>

        <?php if ($this->Session->read('categoria') != 'estudante'): ?>
            <th><?php echo $this->Paginator->sort('nascimento', 'Nascimento'); ?></th>
            <th><?php echo $this->Paginator->sort('cpf', 'CPF '); ?></th>
        <?php endif; ?>

        <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>

        <?php if ($this->Session->read('categoria') != 'estudante'): ?>
            <th><?php echo $this->Paginator->sort('telefone', 'Telefone'); ?></th>
            <th><?php echo $this->Paginator->sort('celular', 'Celular'); ?></th>
        <?php endif; ?>

    </tr>

    <?php foreach ($alunos as $aluno): ?>
        <?php if (empty($aluno['Estagiario'])): ?>
            <tr class='table-danger'>
            <?php else: ?>
            <tr>
            <?php endif; ?>
            <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                <td style='text-align:center'>
                    <?php echo $this->Html->link($aluno['Aluno']['registro'], '/Alunos/view/' . $aluno['Aluno']['id']); ?>
                </td>
            <?php endif; ?>
            <?php if ($this->Session->read('id_categoria') != '2'): ?>
                <?php if (empty($aluno['Estagiario'])): ?>
                    <td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>            
                <?php else: ?>
                    <td style='text-align:left'><?php echo $this->Html->link($aluno['Aluno']['nome'], '/Alunonovos/view/' . $aluno['Estagiario'][0]['Alunonovo']['id']); ?></td>
                <?php endif; ?>
            <?php else: ?>
                <td style='text-align:left'><?php echo $aluno['Aluno']['nome']; ?></td>            
            <?php endif; ?>
            <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                <td style='text-align:center'><?php echo isset($aluno['Aluno']['nascimento']) ? date('d-m-Y', strtotime($aluno['Aluno']['nascimento'])) : NULL; ?></td>
                <td style='text-align:left'><?php echo $aluno['Aluno']['cpf']; ?></td>
            <?php endif; ?>

            <td style='text-align:left'><?php echo $aluno['Aluno']['email']; ?></td>

            <?php if ($this->Session->read('categoria') != 'estudante'): ?>
                <td style='text-align:left'><?php echo $aluno['Aluno']['telefone']; ?></td>
                <td style='text-align:left'><?php echo $aluno['Aluno']['celular']; ?></td>
            <?php endif; ?>

        </tr>

    <?php endforeach; ?>
</table>

<?php
echo $this->Paginator->counter(array(
    'format' => 'Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
));
?>

</div>
