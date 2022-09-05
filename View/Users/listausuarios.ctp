<?php // pr($listausuarios);  ?>
<?php // pr($direcao);           ?>
<?php // pr($linhas);           ?>
<?php // pr($ordem);           ?>
<?php // pr($q_paginas);          ?>
<?php // pr($pagina);          ?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'users', 'action' => 'listausuarios/linhas:')); ?>";
        /* alert(base_url); */

        $("#UserLinhas").change(function () {
            var linhas = $(this).val();
            window.location = base_url + linhas;
        })

    })

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

<?php if ($this->Session->read('categoria') === 'administrador'): ?>

    <?php echo $this->Form->create('User', array(['controller' => 'Users', 'url' => 'listausuarios'], 'class' => 'form-inline')); ?>
    <?php echo $this->Form->input('linhas', array('type' => 'select', 'label' => array('text' => 'Linhas por páginas ', 'style' => 'display: inline'), 'options' => array('15' => '15', '0' => 'Todos'), 'selected' => $linhas, 'empty' => array('15' => 'Selecione'), 'class' => 'form-control')); ?>
    <?php echo $this->Form->end(); ?>

<?php endif; ?>

<div class='pagination justify-content-center'>
    <?php
// Menu superior de Navegação //
    if ($linhas != 0):

        echo "  " . $this->Html->link('<< Início ', 'listausuarios/ordem:' . $ordem . '/pagina:' . 1 . '/q_paginas:' . $q_paginas, ['class' => 'page-link']);

        $retrocederpagina = $pagina - 1;
        echo "  " . $this->Html->link('<- Retroceder ', 'listausuarios/ordem:' . $ordem . '/pagina:' . $retrocederpagina . '/q_paginas:' . $q_paginas, ['class' => 'page-link']);

        $avancarpagina = $pagina + 1;
        if ($avancarpagina > $q_paginas) {
            $pagina = 0;
        } else {
            echo "  " . $this->Html->link(' Avançar -> ', 'listausuarios/ordem:' . $ordem . '/pagina:' . $avancarpagina . '/q_paginas:' . $q_paginas, ['class' => 'page-link']);
        }
        echo "  " . $this->Html->link('Última >> ', 'listausuarios/ordem:' . $ordem . '/pagina:' . $q_paginas . '/q_paginas:' . $q_paginas, ['class' => 'page-link']);
        ?>
    </div>
    <div class='pagination justify-content-center'>
        <?php
        echo "<br>";
        $i = 1;
        $j = 1;
        // echo $j . "<br>";
        for ($k = 0; $k < 10; $k++):
            echo " " . $this->Html->link(($pagina + $k), 'listausuarios/ordem:' . $ordem . '/pagina:' . ($pagina + $k), ['class' => 'page-link']);
            if (($pagina + $k) >= $q_paginas) {
                break;
            }
        endfor;
    endif;
    ?>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th>Excluir</th>
                    <th>Editar</th>
                    <th><?php echo $this->Html->link('Número', 'listausuarios/ordem:numero/direcao:' . $direcao); ?></th>
                    <th><?php echo $this->Html->link('Nome', 'listausuarios/ordem:nome/direcao:' . $direcao); ?></th>
                    <th><?php echo $this->Html->link('Email', 'listausuarios/ordem:email/direcao:' . $direcao); ?></th>
                    <th><?php echo $this->Html->link('Categoria', 'listausuarios/ordem:categoria/direcao:' . $direcao); ?></th>
                </tr>
            </thead>

            <?php foreach ($listausuarios as $usuario): ?>

                <tr>
                    <td>
                        <?php
                        if ($usuario['numero'] != 0):
                            echo $this->Html->link('X', '/users/delete/' . $usuario['id'], NULL, 'Tem certeza?');
                        endif;
                        ?>
                    </td>

                    <td>
                        <?php
                        if ($usuario['numero'] != 0):
                            echo $this->Html->link('Editar', '/users/view/' . $usuario['id']);
                        // echo $this->Html->link('Editar', '/users/view/' . $usuario['numero']);
                        endif;
                        ?>
                    </td>

                    <td>
                        <?php if ($usuario['aluno_tipo'] == 0): ?>
                            <?php if ($usuario['aluno_id']): ?>
                                <?php echo $this->Html->link($usuario['numero'], '/alunonovos/view/' . $usuario['aluno_id']); ?>
                            <?php else: ?>
                                <?php echo $usuario['numero']; ?>
                            <?php endif; ?>
                        <?php elseif ($usuario['aluno_tipo'] == 1): ?>
                            <?php if ($usuario['aluno_id']): ?>
                                <?php echo $this->Html->link($usuario['numero'], '/alunonovos/view/' . $usuario['aluno_id']); ?>
                            <?php else: ?>
                                <?php echo $usuario['numero']; ?>
                            <?php endif; ?>
                        <?php elseif ($usuario['aluno_tipo'] == 2): ?>
                            <?php echo $usuario['numero']; ?>
                        <?php elseif ($usuario['aluno_tipo'] == 3): ?>
                            <?php echo $this->Html->link($usuario['numero'], '/professors/view/' . $usuario['aluno_id']); ?>
                        <?php elseif ($usuario['aluno_tipo'] == 4): ?>
                            <?php echo $this->Html->link($usuario['numero'], '/supervisors/view/' . $usuario['aluno_id']); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $usuario['nome']; ?>
                    </td>
                    <td>
                        <?php echo $usuario['email']; ?>
                    </td>
                    <td>
                        <?php echo $usuario['categoria']; ?>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>
    </div>
</div>