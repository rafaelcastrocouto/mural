<?= $this->element('submenu_alunonovos'); ?>
<?php if ($id_categoria == '1'): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunonovos/busca'); ?> 
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunonovos/busca_dre'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por Email', '/alunonovos/busca_email'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunonovos/busca_cpf'); ?>
    </p>
<?php endif; ?>
<?php if (isset($alunos)): ?>

    <h1>Resultado da busca por CPF</h1>
    <table class="table table-hover table-striped table-responsive">
        <?php foreach ($alunos as $c_alunos): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($c_alunos['Alunonovo']['nome'], '/alunonovos/view/' . $c_alunos['Alunonovo']['id']) . '<br>'; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>

    <h1>Busca por CPF</h1>

    <?= $this->Html->script("jquery.maskedinput"); ?>

    <script>
        $(document).ready(function () {
            $("#AlunonovoCpf").mask("999999999-99");
        });
    </script>

    <?php echo $this->Form->create('Alunonovo'); ?>
    <?php echo $this->Form->input('cpf', array('label' => ['text' => 'Digite o CPF'], 'maxsize' => 12, 'size' => 12, 'class' => 'form-control')); ?>
    <div class='row justify-content-between'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>

<?php endif; ?>
