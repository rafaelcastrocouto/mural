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
            /* alert(categoria); */
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
            <?php echo $this->Form->end(); ?>
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
                    <?php
                    switch ($categoria) {
                        case 2:
                            ?>
                            <th><?php echo $this->Paginator->sort('Alunonovo.registro', 'Número'); ?></th>
                            <th><?php echo $this->Paginator->sort('Alunonovo.nome', 'Nome'); ?></th>
                            <th><?php echo $this->Paginator->sort('Alunonovo.email', 'Email'); ?></th>
                            <?php
                            break;
                        case 3:
                            ?>
                            <th><?php echo $this->Paginator->sort('Professor.siape', 'Número'); ?></th>
                            <th><?php echo $this->Paginator->sort('Professor.nome', 'Nome'); ?></th>
                            <th><?php echo $this->Paginator->sort('Professor.email', 'Email'); ?></th>
                            <?php
                            break;
                        case 4:
                            ?>
                            <th><?php echo $this->Paginator->sort('Supervisor.cress', 'Número'); ?></th>
                            <th><?php echo $this->Paginator->sort('Supervisor.nome', 'Nome'); ?></th>
                            <th><?php echo $this->Paginator->sort('Supervisor.email', 'Email'); ?></th>
                            <?php
                            break;
                        default:
                            ?>
                            <th><?php echo $this->Paginator->sort('User.numero', 'Número'); ?></th>
                            <th><?php echo $this->Paginator->sort('Supervisor.nome', 'Nome'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.email', 'Email'); ?></th>
                            <?php
                            break;
                    };
                    ?>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($usuarios as $c_usuarios):
                    // pr($c_usuarios);
                    ?>
                    <tr>
                        <td><?= $this->Html->link($c_usuarios['User']['id'], '/Users/delete/' . $c_usuarios['User']['id'], NULL, 'Tem certeza?'); ?></td>
                        <td><?= $c_usuarios['Role']['categoria']; ?></td>
                        <?php if ($categoria == 2): ?>
                            <td><?= $this->Html->link($c_usuarios['Alunonovo']['registro'], '/Alunonovos/view/' . $c_usuarios['Alunonovo']['id']); ?></td>
                            <td><?= $c_usuarios['Alunonovo']['nome']; ?></td>
                            <td><?= $c_usuarios['Alunonovo']['email']; ?></td>
                        <?php elseif ($categoria == 3): ?>
                            <td><?= $this->Html->link($c_usuarios['Professor']['siape'], '/Professors/view/' . $c_usuarios['Professor']['id']); ?></td>
                            <td><?= $c_usuarios['Professor']['nome']; ?></td>
                            <td><?= $c_usuarios['Professor']['email']; ?></td>
                        <?php elseif ($categoria == 4): ?>
                            <td><?= $this->Html->link($c_usuarios['Supervisor']['cress'], '/Supervisors/view/' . $c_usuarios['Supervisor']['id']); ?></td>
                            <td><?= $c_usuarios['Supervisor']['nome']; ?></td>
                            <td><?= $c_usuarios['Supervisor']['email']; ?></td>
                        <?php else: ?>
                            <td><?= $this->Html->link($c_usuarios['User']['numero'], '/Users/view/' . $c_usuarios['Supervisor']['id']); ?></td>
                            <td><?= $c_usuarios['Supervisor']['nome']; ?></td>
                            <td><?= $c_usuarios['User']['email']; ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                endforeach;
                ?>

            </tbody>
        </table>

    </div>
</div>
