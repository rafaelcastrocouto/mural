<?php
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

<?php if ($id_categoria == '1'): ?>

    <?= $this->Html->link('Configurações', '/configuracaos/view/1') ?>
    <?= " | " ?>
    <?= $this->Html->link('Lista de usuários', '/users/listausuarios/') ?>
    <?= " | " ?>
    <?= $this->Html->link('Usuários', '/users/index/') ?>
    <?= " | " ?>
    <?= $this->Html->link('Busca por numero', '/users/busca_numero') ?>
    <?= " | " ?>
    <?= $this->Html->link('Busca por Email', '/users/busca_email') ?>
    <?= " | " ?>
    <?= $this->Html->link('Usuários', '/users/listausuarios') ?>
    <?= " | " ?>
    <?= $this->Html->link('Alterna usuário', '/users/alternarusuario') ?>

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
        <?php
        switch ($categoria) {
            case '2':
                ?>
                <table class='table table-hover table-striped table-responsive'>
                    <thead class='thead-light'>
                        <tr>
                            <th><?php echo $this->Paginator->sort('User.id', 'Id'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.numero', 'Número'); ?></th>
                            <th><?php echo $this->Paginator->sort('Estudante.nome', 'Nome'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.email', 'Email'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.categoria', 'Categoria'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usuarios as $c_usuarios) {
                            ?>

                            <tr>
                                <td><?php echo $this->Html->link($c_usuarios['User']['id'], '/Users/delete/' . $c_usuarios['User']['id'], NULL, 'Tem certeza?'); ?></td>
                                <td><?php echo $this->Html->link($c_usuarios['Estudante']['registro'], '/Alunonovos/view/' . $c_usuarios['Estudante']['id']); ?></td>
                                <td><?php echo $c_usuarios['Estudante']['nome']; ?></td>
                                <td><?php echo $c_usuarios['User']['email']; ?></td>
                                <td><?php echo $c_usuarios['Role']['categoria']; ?></td>
                            </tr>

                            <?php
                        }
                        ?>
                    <tbody>
                </table>
                <?php
                break;
            case '3':
                ?>
                <table class='table table-hover table-striped table-responsive'>
                    <thead class='thead-light'>
                        <tr>
                            <th><?php echo $this->Paginator->sort('User.id', 'Id'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.numero', 'Número'); ?></th>
                            <th><?php echo $this->Paginator->sort('Professor.nome', 'Nome'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.email', 'Email'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.categoria', 'Categoria'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usuarios as $c_usuarios) {
                            ?>

                            <tr>
                                <td><?php echo $this->Html->link($c_usuarios['User']['id'], '/Users/delete/' . $c_usuarios['User']['id'], NULL, 'Tem certeza?'); ?></td>
                                <td><?php echo $this->Html->link($c_usuarios['Professor']['siape'], '/Professors/view/' . $c_usuarios['Professor']['id']); ?></td>
                                <td><?php echo $c_usuarios['Professor']['nome']; ?></td>
                                <td><?php echo $c_usuarios['User']['email']; ?></td>
                                <td><?php echo $c_usuarios['Role']['categoria']; ?></td>
                            </tr>

                            <?php
                        }
                        ?>
                    <tbody>
                </table>
                <?php
                break;
            case '4':
                ?>
                <table class='table table-hover table-striped table-responsive'>
                    <thead class='thead-light'>
                        <tr>
                            <th><?php echo $this->Paginator->sort('User.id', 'Id'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.numero', 'Número'); ?></th>
                            <th><?php echo $this->Paginator->sort('Supervisor.nome', 'Nome'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.email', 'Email'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.categoria', 'Categoria'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usuarios as $c_usuarios) {
                            ?>

                            <tr>
                                <td><?php echo $this->Html->link($c_usuarios['User']['id'], '/Users/delete/' . $c_usuarios['User']['id'], NULL, 'Tem certeza?'); ?></td>
                                <td><?php echo $this->Html->link($c_usuarios['Supervisor']['cress'], '/supervisors/view/' . $c_usuarios['Supervisor']['id']); ?></td>
                                <td><?php echo $c_usuarios['Supervisor']['nome']; ?></td>
                                <td><?php echo $c_usuarios['User']['email']; ?></td>
                                <td><?php echo $c_usuarios['Role']['categoria']; ?></td>
                            </tr>

                            <?php
                        }
                        ?>
                    <tbody>
                </table>
                <?php
                break;
            default :
                ?>
                <table class='table table-hover table-striped table-responsive'>
                    <thead class='thead-light'>
                        <tr>
                            <th><?php echo $this->Paginator->sort('User.id', 'Id'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.numero', 'Número'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.email', 'Email'); ?></th>
                            <th><?php echo $this->Paginator->sort('User.categoria', 'Categoria'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usuarios as $c_usuarios) {
                            ?>

                            <tr>
                                <td><?php echo $this->Html->link($c_usuarios['User']['id'], '/Users/delete/' . $c_usuarios['User']['id'], NULL, 'Tem certeza?'); ?></td>
                                <td><?php echo $c_usuarios['User']['numero']; ?></td>
                                <td><?php echo $c_usuarios['User']['email']; ?></td>
                                <td><?php echo $c_usuarios['Role']['categoria']; ?></td>
                            </tr>

                            <?php
                        }
                        ?>
                    <tbody>
                </table>
            <?php
        };
        ?>
    </div>
</div>
