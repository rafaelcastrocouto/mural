
<?php 

$categoria_id = 0;

if ($session) {
    $categoria_id = $session->get('categoria_id');
}

// pr($alunos);
// die();
?>

<?php if (isset($alunos)): ?>

    <h1>Resultado da busca por nome de estudante</h1>
    <div class='row justify-content-center'>
        <?php $this->Paginator->options(array('url' => array($nome))); ?>

        <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->numbers(); ?>
        <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>
    </div>
    <table class='table table-hover table-striped table-responsive'>
        <thead class='thead-light'>
            <tr>
                <th><?php echo $this->Paginator->sort('registro', 'DRE'); ?></th>
                <th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>
                <th><?php echo $this->Paginator->sort('cpf', 'CPF'); ?></th>
                <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>
            </tr>
        </thead>
        <?php foreach ($alunos as $aluno): ?>
            <tr>
                <td><?php echo $aluno['Aluno']['registro']; ?></td>
                <td><?php echo $this->Html->link($aluno['Aluno']['nome'], '/alunos/view/' . $aluno['Aluno']['id']); ?></td>
                <td><?php echo $aluno['Aluno']['cpf']; ?></td>
                <td><?php echo $aluno['Aluno']['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>
    <div>
        <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
        <?php echo $this->Form->control('nome', ['label' => ['text' => 'Digite o nome do aluno'], 'class' => 'form-control']); ?>
        <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma'], 'class' => 'button']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
<?php endif; ?>
