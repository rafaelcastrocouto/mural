<?= $this->element('submenu_alunos'); ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunos/busca', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunos/busca_dre', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por Email', '/alunos/busca_email', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunos/busca_cpf', ['role' => 'button', 'class' => 'btn btn-info']); ?>
    </p>
<?php endif; ?>

<?php if (isset($alunos)): ?>

    <h1>Resultado da busca por Email</h1>

    <?php foreach ($alunos as $c_alunos): ?>
        <?php echo $this->Html->link($c_alunos['Aluno']['nome'], '/alunos/view/' . $c_alunos['Aluno']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <?php echo $this->Form->create('Aluno'); ?>
    <?php echo $this->Form->input('email', ['label' => ['text' => 'Digite o email'], 'maxsize' => 70, 'size' => 70, 'class' => 'form-control']); ?>

    <div class='row justify-content-left'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>

<?php endif; ?>
