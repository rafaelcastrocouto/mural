<?php
// pr($usuario);
// pr($aluno);
// pr($alunonovo);
// pr($professor);
// pr($supervisor);
// die();
?>

<?= $this->element('submenu_usuarios') ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>

    <?= $this->Html->link('Configurações', '/configuracaos/view/1', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Lista de usuários', '/users/listausuarios/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Usuários', '/users/index/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por numero', '/users/busca_numero', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por Email', '/users/busca_email', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Alterna usuário', '/users/alternarusuario', ['role' => 'button', 'class' => 'btn btn-info']) ?>

<?php endif; ?>

<div class='table-responsive'>
    <table class='table table-hover table-striped table-responsive'>
        <thead>
        <th>Tabela</th>
        <th>Nome</th>
        <th>Número</th>
        <th>E-mail</th>
        </thead>

        <?php if ($usuario['User']['categoria'] == 2): ?>

            <tr>
                <td>Estudante</td>
                <td><?php echo $usuario['Alunonovo']['nome']; ?></td>
                <td><?php echo $this->Html->link($usuario['Alunonovo']['registro'], '/alunonovos/view/' . $usuario['Alunonovo']['id']); ?></td>
                <td><?php echo $usuario['Alunonovo']['email']; ?></td>
            </tr>

        <?php elseif ($usuario['User']['categoria'] == 3): ?>

            <tr>
                <td>Professor</td>
                <td><?= $this->Html->link($usuario['Professor']['nome'], '/professors/view/' . $usuario['Professor']['id']) ?></td>
                <td><?php echo $usuario['Professor']['siape']; ?></td>
                <td><?php echo $usuario['Professor']['email']; ?></td>
            </tr>

        <?php elseif ($usuario['User']['categoria'] == 4): ?>

            <tr>
                <td>Supervisor</td>
                <td><?= $this->Html->link($usuario['Supervisor']['nome'], '/supervisors/view/' . $usuario['Supervisor']['id']) ?></td>
                <td><?php echo $usuario['Supervisor']['cress']; ?></td>
                <td><?php echo $usuario['Supervisor']['email']; ?></td>
            </tr>

        <?php endif; ?>

        <tr>
            <td>Usuário</td>
            <td></td>
            <td><?php echo $this->Html->link($usuario['User']['numero'], '/users/edit/' . $usuario['User']['id']); ?></td>
            <td><?php echo $usuario['User']['email']; ?></td>
            <td><?= $this->Html->link('Excluir', ['controller' => 'Users',  'action' => 'excluir', $usuario['User']['id']], ['class' => 'btn btn-danger']) ?></td>
        </tr>

    </table>
</div>