<?= $this->element('submenu_alunos'); ?>

<?php if ($id_categoria == '1'): ?>
    <p>
        <?php echo $this->Html->link('Busca por Nome', '/alunos/busca'); ?> 
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por DRE', '/alunos/busca_dre'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por Email', '/alunos/busca_email'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Busca por CPF', '/alunos/busca_cpf'); ?>
    </p>
<?php endif; ?>

<?php if (isset($alunos)): ?>

    <h1>Resultado da busca por CPF</h1>

    <?php foreach ($alunos as $c_alunos): ?>
        <?php echo $this->Html->link($c_alunos['Aluno']['nome'], '/alunos/view/' . $c_alunos['Aluno']['id']) . '<br>'; ?>
    <?php endforeach; ?>

<?php else: ?>

    <h1>Busca por CPF</h1>

    <?= $this->Html->script("jquery.maskedinput"); ?>

    <script>
        $(document).ready(function () {
            $("#AlunoCpf").mask("999999999-99");
        });
    </script>

    <?php echo $this->Form->create('Aluno', ['class' => 'form-inline']); ?>
    <?php echo $this->Form->input('cpf', ['div' => 'form-group row', 'label' => ['text' => 'Digite o CPF', 'class' => 'col-form-label col-4'], 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control required']); ?>
    <div class='row justify-content-left'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>

<?php endif; ?>
