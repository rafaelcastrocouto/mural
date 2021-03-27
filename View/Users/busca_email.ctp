<!--
<?= $this->element('submenu_alunonovos'); ?>
//-->

<?php if ($id_categoria == '1'): ?>
    <p>
        <?= $this->Html->link('Busca por numero', '/users/busca_numero') ?>
        <?= " | "; ?>
        <?= $this->Html->link('Busca por Email', '/users/busca_email') ?>
        <?= " | " ?>
        <?= $this->Html->link('Usuários', '/users/listausuarios') ?>
        <?= " | " ?>
        <?= $this->Html->link('Alterna usuário', '/users/alternarusuario') ?>
    </p>
<?php endif; ?>

<?php if (isset($usuarios)): ?>
    <?php // pr($usuarios); ?>
    <h1>Resultado da busca por Email</h1>
    <table class="table table-hover table-striped table-responsive">
        <?php foreach ($usuarios as $c_alunos): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($c_alunos['User']['numero'], '/users/view/' . $c_alunos['User']['numero']) . '<br>'; ?>
                </td>
                <td>
                    <?php echo $this->Html->link($c_alunos['User']['email'], '/users/view/' . $c_alunos['User']['numero']) . '<br>'; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <h1>Busca por Email</h1>

    <?php echo $this->Form->create('User'); ?>
    <?php echo $this->Form->input('email', array('label' => 'Digite o email', 'maxsize' => 70, 'size' => 70, 'class' => 'form-control')); ?>

    <div class='row justify-content-left'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>

<?php endif; ?>
