<?= $this->element('submenu_usuarios') ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>

    <?= $this->Html->link('Configurações', '/configuracaos/view/1', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Lista de usuários', '/users/listausuarios/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Usuários', '/users/index/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por numero', '/users/busca_numero', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por Email', '/users/busca_email', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Alterna usuário', '/users/alternarusuario', ['role' => 'button', 'class' => 'btn btn-info']) ?>

<?php endif; ?>

<?php if (isset($usuarios)): ?>
    <?php // pr($usuarios); ?>
    <h1>Resultado da busca por Email</h1>
    <table class="table table-hover table-striped table-responsive">
        <tr>
            <td colspan=2>
                <?php if ($usuarios['Role']['id'] == '2'): ?>
                    <?php echo 'Estudante'; ?>
                <?php elseif ($usuarios['Role']['id'] == '3'): ?>
                    <?php echo 'Professor(a)'; ?>
                <?php elseif ($usuarios['Role']['id'] == '4'): ?>
                    <?php echo 'Supervisor(a)'; ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $this->Html->link($usuarios['User']['numero'], '/users/view/' . $usuarios['User']['id']); ?>
            </td>
            <td>
                <?php echo $this->Html->link($usuarios['User']['email'], '/users/view/' . $usuarios['User']['id']); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php if ($usuarios['Role']['id'] == '2'): ?>
                    <?php echo $this->Html->link($segmento['Aluno']['registro'], '/alunos/view/' . $segmento['Aluno']['id']); ?>
                <?php elseif ($usuarios['Role']['id'] == '3'): ?>
                    <?php echo $this->Html->link($segmento['Professor']['siape'], '/professors/view/' . $segmento['Professor']['id']); ?>
                <?php elseif ($usuarios['Role']['id'] == '4'): ?>
                    <?php echo $this->Html->link($segmento['Supervisor']['cress'], '/supervisors/view/' . $segmento['Supervisor']['id']); ?>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($usuarios['Role']['id'] == '2'): ?>
                    <?php echo $this->Html->link($segmento['Aluno']['nome'], '/alunos/view/' . $segmento['Aluno']['id']); ?>
                <?php elseif ($usuarios['Role']['id'] == '3'): ?>
                    <?php echo $this->Html->link($segmento['Professor']['nome'], '/professors/view/' . $segmento['Professor']['id']); ?>
                <?php elseif ($usuarios['Role']['id'] == '4'): ?>
                    <?php echo $this->Html->link($segmento['Supervisor']['nome'], '/supervisors/view/' . $segmento['Supervisor']['id']); ?>
                <?php endif; ?>
            </td>
        </tr>
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
