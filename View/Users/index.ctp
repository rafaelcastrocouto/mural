<?php

// pr($categoria);
// die();
// pr($usuarios);
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'users', 'action' => 'index')); ?>";
        /* alert(base_url); */

        $("#UserCategoria").change(function () {
            var categoria = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "/index?categoria=" + categoria;
        })

    });

</script>

<?= $this->element('submenu_usuarios') ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>

    <?= $this->Html->link('Configurações', '/configuracaos/view/1', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Lista de usuários', '/users/listausuarios/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Usuários', '/users/index/', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por numero', '/users/busca_numero', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Busca por Email', '/users/busca_email', ['role' => 'button', 'class' => 'btn btn-info']) ?>
    <?= $this->Html->link('Alterna usuário', '/users/alternarusuario', ['role' => 'button', 'class' => 'btn btn-info']) ?>

<?php endif; ?>

<table 'class="table table-responsive">
    <tr>
        <td>
            <?php echo $this->Form->create('User', array('inputDefaults' => array('label' => false, 'div' => false))); ?>
            <?php echo $this->Form->input('categoria', array('type' => 'select', 'options' => ['1' => 'Administrador', '2' => 'Estudante', '3' => 'Professor(a)', '4' => 'Supervisor(a)'], 'value' => $categoria, 'empty' => array('0' => 'Categoria'), 'style' => 'width: 15em', 'class' => 'form-control form-control-sm')); ?>
            <?php // echo $this->Form->end(); ?>
        </td>
</table>

<div class='pagination justify-content-center'>
    <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
    <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
</div>

<div class="pagination justify-content-center">
    <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th><?php echo $this->Paginator->sort('User.id', 'Id'); ?></th>
                    <th><?php echo $this->Paginator->sort('User.categoria', 'Categoria'); ?></th>
                    <th><?php echo $this->Paginator->sort('User.numero', 'Número'); ?></th>
                    <th><?php echo $this->Paginator->sort('User.Alunonovo.nome', 'Nome'); ?></th>
                    <th><?php echo $this->Paginator->sort('User.email', 'Email'); ?></th>

                </tr>
            </thead>
            <tbody>

        <?php
        foreach ($usuarios as $c_usuarios) {
        ?>
                <?php // pr($c_usuarios) ?>
                <tr>
                    <td><?= $this->Html->link($c_usuarios['User']['id'], '/Users/delete/' . $c_usuarios['User']['id'], NULL, 'Tem certeza?'); ?></td>
                    <td><?= $c_usuarios['Role']['categoria']; ?></td>
                    <?php if ($c_usuarios['User']['categoria'] == 2): ?>
                    <td><?= $this->Html->link($c_usuarios['Alunonovo']['registro'], '/Alunonovos/view/' . $c_usuarios['Alunonovo']['id']); ?></td>
                    <td><?= $c_usuarios['Alunonovo']['nome']; ?></td>
                    <td><?= $c_usuarios['Alunonovo']['email']; ?></td>
                    <?php elseif ($c_usuarios['User']['categoria'] == 3): ?>
                    <td><?= $this->Html->link($c_usuarios['Docente']['siape'], '/Docentes/view/' . $c_usuarios['Docente']['id']); ?></td>
                    <td><?= $c_usuarios['Docente']['nome']; ?></td>
                    <td><?= $c_usuarios['Docente']['email']; ?></td>
                    <?php elseif ($c_usuarios['User']['categoria'] == 4): ?>
                    <td><?= $this->Html->link($c_usuarios['Supervisor']['cress'], '/Supervisores/view/' . $c_usuarios['Supervisor']['id']); ?></td>
                    <td><?= $c_usuarios['Supervisor']['nome']; ?></td>
                    <td><?= $c_usuarios['Supervisor']['email']; ?></td>
                    <?php endif; ?>
                </tr>
        <?php
        }
        ?>

            </tbody>
        </table>

    </div>
</div>
