<?= $this->element('submenu_alunonovos') ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunonovos/busca', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunonovos/busca_dre', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por Email', '/alunonovos/busca_email', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunonovos/busca_cpf', ['role' => 'button', 'class' => 'btn btn-info']); ?>
    </p>
<?php endif; ?>

<?php if (isset($alunos)): ?>

    <div class="table-responsive">

        <div class='row justify-content-center'>
            <div class="col-auto">
                <h1>Resultado da busca por nome de estudante</h1>
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class="col-auto">
                <?php $this->Paginator->options(array('url' => array($nome))); ?>

                <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
                <?php echo $this->Paginator->numbers(); ?>
                <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>
            </div>
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
                    <td><?php echo $c_aluno['Alunonovo']['registro']; ?></td>
                    <td><?php echo $this->Html->link($c_aluno['Alunonovo']['nome'], '/alunonovos/view/' . $c_aluno['Alunonovo']['id']); ?></td>
                    <td><?php echo $c_aluno['Alunonovo']['cpf']; ?></td>
                    <td><?php echo $c_aluno['Alunonovo']['email']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php else: ?>

    <div class='table-responsive'>
       
        <?php echo $this->Form->create('Alunonovo'); ?>

        <?php echo $this->Form->input('nome', array('label' => ['text' => 'Digite o nome do aluno'], 'class' => 'form-control')); ?>
        <div class='row justify-content-left'>
            <div class='col-auto'>
                <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma'], 'class' => 'btn btn-primary']); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>

<?php endif; ?>
