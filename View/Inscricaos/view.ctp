<?php
// pr($inscricao);
?>
<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <?php echo $this->Html->link('Listar', '/Inscricaos/index/', ['class' => 'btn btn-primary']); ?>

    <h1>Inscrição para seleção de estágio</h1>

    <table class="table table-hover table-striped table-responsive">

        <tr>
            <td>Registro</td>
            <td><?php echo $this->Html->link($inscricao['Inscricao']['id_aluno'], ['controller' => 'alunonovos', 'action' => 'view', $inscricao['Inscricao']['alunonovo_id']]); ?></td>
        </tr>

        <tr>
            <td>Nome</td>
            <td>
                <?php
                if ($inscricao['Aluno']['nome']) {
                    echo $inscricao['Aluno']['nome'];
                } else {
                    echo strtoupper($inscricao['Alunonovo']['nome']);
                }
                ?> 
            </td>
        </tr>

        <tr>
            <td>Instituição</td>
            <td><?php echo $this->Html->link($inscricao['Mural']['instituicao'], ['controller' => 'inscricaos', 'action' => 'index', $inscricao['Inscricao']['id_instituicao']]); ?></td>
        </tr>

        <tr>
            <td>Data</td>
            <td><?php echo (date('d-m-Y', strtotime($inscricao['Inscricao']['data']))); ?></td>
        </tr>

        <tr>
            <td>Período</td>
            <td><?php echo $inscricao['Inscricao']['periodo']; ?></td>
        </tr>

    </table>

    <hr>

    <?php echo $this->Html->link('Editar', '/Inscricaos/edit/' . $inscricao['Inscricao']['id'], ['class' => 'btn btn-info']); ?>

    <?php echo $this->Html->link('Excluir', '/Inscricaos/delete/' . $inscricao['Inscricao']['id'], ['class' => 'btn btn-danger'], NULL, 'Tem certeza?'); ?>

</div>
