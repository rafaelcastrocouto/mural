<?php
// pr($alunos);
// pr($estagios);
// pr($c_estagios);
// pr($nao_obrigatorio);
?>
<div class=table-responsive'>
    <?= $this->element('submenu_folhadeatividades'); ?>

    <?php if ($this->Session->read('id_categoria') == '1'): ?>
        <?php echo $this->Html->link('Alunos', '/Alunos/index'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Estagiários', '/Estagiarios/index'); ?>
        <?php echo " | "; ?>
        <?php echo $this->Html->link('Usuários', '/Users/listausuarios'); ?>
    <?php endif; ?>

    <div align="center">
        <h2><?php echo $alunos['nome']; ?></h2>
    </div>

</div>

<div class='table-responsive'>
    <div align="center">
        <h2>Estágios cursados</h2>
    </div>
    <table class='table table-striped table-hover table-responsive'>
        <thead class='thead-light'>
            <tr>
                <th>Ver</th>
                <th>Período</th>
                <th>Complemento</th>
                <th>Nível</th>
                <th>Turno</th>
                <th>TC</th>
                <th>Instituição</th>
                <th>Supervisor</th>
                <th>Professor</th>
                <th>Área</th>

                <th>Nota</th>
                <th>CH</th>
            </tr>
        </thead>
        <?php foreach ($c_estagios as $aluno_estagio): ?>
            <tr>
                <td>
                    <?php if ($this->Session->read('id_categoria') == '1'): ?>
                        <?= $this->Html->link('Ver', '/folhadeatividades/atividade?estagiario_id=' . $aluno_estagio['id']); ?>
                    <?php elseif ($this->Session->read('id_categoria') != '1'): ?>    
                        <?= $this->Html->link('Ver', '/folhadeatividades/atividade?estagiario_id=' . $aluno_estagio['id']); ?>
                    <?php endif; ?>
                </td>
                <td><?php echo $aluno_estagio['periodo'] ?></td>
                <td><?php echo $aluno_estagio['complemento_periodo_especial'] ?></td>
                <td style='text-align:center'><?php echo $aluno_estagio['nivel']; ?></td>
                <td style='text-align:center'><?php echo $aluno_estagio['turno']; ?></td>
                <td style='text-align:center'><?php echo $aluno_estagio['tc']; ?></td>
                <td><?php echo $this->Html->link($aluno_estagio['instituicao'], '/Instituicaos/view/' . $aluno_estagio['id_instituicao']); ?></td>
                <td><?php echo $this->Html->link($aluno_estagio['supervisor'], '/Supervisors/view/' . $aluno_estagio['id_supervisor']); ?></td>
                <td><?php echo $this->Html->link($aluno_estagio['professor'], '/Professors/view/' . $aluno_estagio['id_professor']); ?></td>
                <td><?php echo $this->Html->link($aluno_estagio['area'], '/Areas/view/' . $aluno_estagio['id_area']); ?></td>
                <td style='text-align:center'><?php echo $aluno_estagio['nota']; ?></td>
                <td style='text-align:center'><?php echo $aluno_estagio['ch']; ?></td>

            </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="table-responsive">
    <?php if (isset($nao_obrigatorio) && !(empty($nao_obrigatorio))): ?>
        <h2>Estágios não obrigatórios</h2>
        <table class="table table-striped table-hover table-responsive">
            <?php foreach ($nao_obrigatorio as $aluno_nao_estagio): ?>
                <tr>
                    <?php if ($this->Session->read('id_categoria') == '1'): ?>
                        <td>
                            <?php echo $this->Html->link('Ver', '/Estagiarios/view/', $aluno_nao_estagio['id']); ?>
                        </td>
                    <?php endif; ?>

                    <td><?php echo $aluno_nao_estagio['periodo'] ?></td>
                    <td><?php echo $aluno_estagio['complemento_periodo_especial'] ?></td>
                    <td style='text-align:center'><?php echo "Não obrigatório"; ?></td>
                    <td style='text-align:center'><?php echo $aluno_nao_estagio['turno']; ?></td>
                    <td style='text-align:center'><?php echo $aluno_nao_estagio['tc']; ?></td>
                    <td><?php echo $this->Html->link($aluno_nao_estagio['instituicao'], '/Instituicaos/view/' . $aluno_nao_estagio['id_instituicao']); ?></td>
                    <td><?php echo $this->Html->link($aluno_nao_estagio['supervisor'], '/Supervisors/view/' . $aluno_nao_estagio['id_supervisor']); ?></td>
                    <td><?php echo $this->Html->link($aluno_nao_estagio['professor'], '/Professors/view/' . $aluno_estagio['id_professor']); ?></td>
                    <td><?php echo $this->Html->link($aluno_nao_estagio['area'], '/Areas/view/' . $aluno_nao_estagio['id_area']); ?></td>
                    <td style='text-align:center'><?php echo $aluno_nao_estagio['nota']; ?></td>
                    <td style='text-align:center'><?php echo $aluno_nao_estagio['ch']; ?></td>

                </tr>
            <?php endforeach; ?>
        <?php endif; ?>

    </table>

</div>
