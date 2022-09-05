<?= $this->element('submenu_alunonovos'); ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunonovos/busca', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunonovos/busca_dre', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por Email', '/alunonovos/busca_email', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunonovos/busca_cpf', ['role' => 'button', 'class' => 'btn btn-info']); ?>
    </p>
<?php endif; ?>

<?php if (isset($alunos)): ?>

    <h1>Resultado da busca por Email</h1>
    <table class="table table-hover table-striped table-responsive">
        <?php foreach ($alunos as $c_alunos): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($c_alunos['Alunonovo']['nome'], '/alunonovos/view/' . $c_alunos['Alunonovo']['id']) . '<br>'; ?>
                </td>
                <td>
                    <?php echo $this->Html->link($c_alunos['Alunonovo']['email'], '/alunonovos/view/' . $c_alunos['Alunonovo']['id']) . '<br>'; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    
<?php else: ?>

    <?php echo $this->Form->create('Alunonovo'); ?>
    <?php echo $this->Form->input('email', array('label' => 'Digite o email', 'maxsize' => 70, 'size' => 70, 'class' => 'form-control')); ?>

    <div class='row justify-content-left'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>

<?php endif; ?>
