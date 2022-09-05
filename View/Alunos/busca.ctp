<?= $this->element('submenu_alunos'); ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunos/busca', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunos/busca_dre', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por Email', '/alunos/busca_email', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunos/busca_cpf', ['role' => 'button', 'class' => 'btn btn-info']); ?>
    </p>
<?php endif; ?>

<?php
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
        <?php foreach ($alunos as $c_aluno): ?>
            <tr>
                <td><?php echo $c_aluno['Aluno']['registro']; ?></td>
                <td><?php echo $this->Html->link($c_aluno['Aluno']['nome'], '/alunos/view/' . $c_aluno['Aluno']['id']); ?></td>
                <td><?php echo $c_aluno['Aluno']['cpf']; ?></td>
                <td><?php echo $c_aluno['Aluno']['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <?php echo $this->Form->create('Aluno') ?>
    <?php echo $this->Form->input('nome', array('label' => ['text' => 'Digite o nome do aluno'], 'class' => 'form-control')); ?>
    <div class='row justify-content-between'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
<?php endif; ?>
