<?php // pr($inscritos)     ?>
<?php // die();      ?>

<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <?= $this->Html->link('Listar mural', '/murals/index', ['class' => 'btn btn-primary']) ?>

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

        <div class='pagination justify-content-center'>
            <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
            <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
        </div>
        
        <div class="pagination justify-content-center">
            <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
        </div>

        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <?php if ($this->Session->read('id_categoria') === 1): ?>
                        <th><?= $this->Paginator->sort('Inscricao.id', 'Id') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.registro', 'DRE') ?></th>
                        <th>T</th>
                        <th><?= $this->Paginator->sort('Inscricao.data', 'Data') ?></th>
                        <th><?= $this->Paginator->sort('Mural.instituicao', 'Estágio') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.nome', 'Estudante') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.nascimento', 'Nascimento') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.telefone', 'Telefone') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.celular', 'Celular') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.email', 'Email') ?></th>
                    <?php else: ?>
                        <th><?= $this->Paginator->sort('Alunonovo.registro', 'DRE') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.nome', 'Estudante') ?></th>
                        <th><?= $this->Paginator->sort('Inscricao.data', 'Data inscrição') ?></th>
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
                            <td><?php echo $this->Html->link($c_inscrito['Inscricao']['id'], '/inscricaos/view/' . $c_inscrito['Inscricao']['id']); ?></td>
                            <td><?php echo $c_inscrito['Inscricao']['id_aluno']; ?></td>
                            <td><?php echo empty($c_inscrito['Alunonovo']['Estagiario']) ? 0 : 1; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($c_inscrito['Inscricao']['data'])); ?></td>
                            <td><?php echo $this->Html->link($c_inscrito['Mural']['instituicao'], '/Murals/view/' . $c_inscrito['Mural']['id']); ?></td>
                            <td><?php echo $this->Html->link($c_inscrito['Alunonovo']['nome'], '/Alunonovos/view/' . $c_inscrito['Alunonovo']['id']); ?></td>
                            <td><?php echo isset($c_inscrito['Alunonovo']['nascimento']) ? date('d-m-Y', strtotime($c_inscrito['Alunonovo']['nascimento'])) : NULL; ?></td>
                            <td><?php echo $c_inscrito['Alunonovo']['telefone']; ?></td>
                            <td><?php echo $c_inscrito['Alunonovo']['celular']; ?></td>
                            <td><?php echo $c_inscrito['Alunonovo']['email']; ?></td>
                        <?php else: ?>
                            <td><?php echo $c_inscrito['Inscricao']['id_aluno']; ?></td>
                            <td><?php echo $c_inscrito['Alunonovo']['nome']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($c_inscrito['Inscricao']['data'])); ?></td>
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

    <?php
    echo $this->Paginator->counter(array(
        'format' => 'Página %page% de %pages%,
    exibindo %current% registros do %count% total,
    começando no registro %start%, finalizando no %end%'
    ));
    ?>

</div>
