<?php // pr($inscritos)     ?>
<?php // die();      ?>

<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <?= $this->Html->link('Listar mural', '/murals/index') ?>

    <h1>
        Estudantes inscritos para estágio
        <?php
        if (isset($periodo)) {
            echo " " . $periodo;
        }
        ?>
    </h1>

    <?php
    if (isset($instituicao)):
        ?>
        <h1><?php
            echo $this->Html->link($instituicao . ': ', '/murals/view/' . $mural_id);
            echo " Vagas: " . $vagas
            ?></h1>
        <?php
        echo $this->Html->link($instituicao . ': ', '/estagiarios/index/id_instituicao:' . $id_instituicao . '/periodo:' . $periodo);
        ;
        echo " Estagiarios: " . $estagiarios;
        ?>
        <?php
    endif;
    ?>

    <?php
    if (isset($inscritos)):
        ?>
        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <?php if ($this->Session->read('id_categoria') === 1): ?>
                        <th><a href="?ordem=id">Id</a></th>
                        <th><a href="?ordem=id_aluno">DRE</a></th>
                        <th><a href="?ordem=tipo">T</a></th>
                        <th><a href="?ordem=data">Data</a></th>
                        <th><a href="?ordem=mural_instituicao">Estágio</a></th>
                        <th><a href="?ordem=nome">Estudante</a></th>
                        <th><a href="?ordem=nascimento">Nascimento</a></th>
                        <th><a href="?ordem=telefone">Telefone</a></th>
                        <th><a href="?ordem=celular">Celular</a></th>
                        <th><a href="?ordem=email">Email</a></th>
                    <?php else: ?>
                        <th><a href="?ordem=id_aluno">DRE</a></th>
                        <th><a href="?ordem=nome">Estudante</a></th>
                        <th><a href="?ordem=data">Data inscrição</a></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $registro = NULL;
                foreach ($inscritos as $c_inscrito):
                    // pr($c_inscrito);
                    // die();
                    ?>
                    <tr>
                        <?php if ($this->Session->read('id_categoria') === 1): ?>
                            <td><?php echo $this->Html->link($c_inscrito['id_inscricao'], '/inscricaos/view/' . $c_inscrito['id_inscricao']); ?></td>
                            <td><?php echo $c_inscrito['id_aluno']; ?></td>
                            <td><?php echo $c_inscrito['tipo']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($c_inscrito['data'])); ?></td>
                            <td><?php echo $this->Html->link($c_inscrito['mural_instituicao'], '/Murals/view/' . $c_inscrito['id_instituicao']); ?></td>
                            <td>
                                <?php
                                if ($c_inscrito['tipo'] === 0) {
                                    echo $this->Html->link($c_inscrito['nome'], '/Alunonovos/view/' . $c_inscrito['id']);
                                } else {
                                    echo $this->Html->link($c_inscrito['nome'], '/Alunos/view/' . $c_inscrito['id']);
                                }
                                ?>
                            </td>
                            <td><?php echo date('d-m-Y', strtotime($c_inscrito['nascimento'])); ?></td>
                            <td><?php echo $c_inscrito['telefone']; ?></td>
                            <td><?php echo $c_inscrito['celular']; ?></td>
                            <td><?php echo $c_inscrito['email']; ?></td>
                        <?php else: ?>
                            <td><?php echo $c_inscrito['id_aluno']; ?></td>
                            <td><?php echo $c_inscrito['nome']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($c_inscrito['data'])); ?></td>
                            <?php // pr($c_inscrito) ?>
                            <?php // die(); ?>
                        <?php endif; ?>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    endif;
    ?>
</div>
