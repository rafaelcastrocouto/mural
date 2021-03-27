<?php

// pr($alunos);
// pr($estagios);
// pr($c_estagios);
// pr($nao_obrigatorio);
?>
<div class=table-responsive'>
    <?= $this->element('submenu_alunos'); ?>

<?php if ($this->Session->read('id_categoria') == '1'): ?>
    <?php echo $this->Html->link('Alunos', '/Alunos/index'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Estagiários', '/Estagiarios/index'); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link('Usuários', '/Users/listausuarios'); ?>
<?php endif; ?>

<?php if ($this->Session->read('id_categoria') != '2'): ?>
    <div align="center">
    <?php echo $this->Html->link('Retroceder', array('action' => 'view', $registro_prev)) . " "; ?> |
    <?php echo $this->Html->link('Avançar', array('action' => 'view', $registro_next)); ?>
    </div>
<?php endif; ?>

    <div align="center">
        <h2><?php echo $alunos['nome']; ?></h2>
    </div>

<?php
if (is_null($alunos['nascimento'])) {
    $nascimento = 'Sem dados';
} elseif ($alunos['nascimento'] == 0) {
    $nascimento = 'Sem informação';
} else {
    $nascimento = date('d-m-Y', strtotime($alunos['nascimento']));
}
?>

    <table class='table table-striped table-hover table-responsive'>
        <tr>
            <td style='text-align:left'>Registro: <?php echo $alunos['registro']; ?></td>
            <td style='text-align:left'>CPF: <?php echo $alunos['cpf']; ?></td>
            <td style='text-align:left'>Carteira de identidade: <?php echo $alunos['identidade']; ?></td>
            <td style='text-align:left'>Orgão: <?php echo $alunos['orgao']; ?></td>
        </tr>
        <tr>
            <td style='text-align:left'>Nascimento: <?php echo $nascimento; ?></td>
            <td style='text-align:left'>Email: <?php echo $alunos['email']; ?></td>
            <td style='text-align:left'>Telefone: <?php echo "(" . $alunos['codigo_telefone'] . ")" . $alunos['telefone']; ?></td>
            <td style='text-align:left'>Celular: <?php echo "(" . $alunos['codigo_celular'] . ")" . $alunos['celular']; ?></td>
        </tr>
        <tr>
            <td style='text-align:left'>Endereço: <?php echo $alunos['endereco']; ?></td>
            <td style='text-align:left'>Bairro: <?php echo $alunos['bairro']; ?></td>
            <td style='text-align:left'>Municipio: <?php echo $alunos['municipio']; ?>
            <td style='text-align:left'>CEP: <?php echo $alunos['cep']; ?></td>
        </tr>
    </table>

<p>
    <?php if ($this->Session->read('id_categoria') == '1'): ?>
        <?php echo $this->Html->link('Excluir', '/Alunos/delete/' . $alunos['id'], NULL, 'Tem certeza?'); ?>
        <?php echo " | "; ?>
    <?php endif; ?>

    <?php if (($this->Session->read('id_categoria') == '2') && ($this->Session->read('numero') == $alunos['registro'])): ?>
        <?php echo $this->Html->link('Editar', '/Alunos/edit/' . $alunos['id']); ?>
    <?php elseif ($this->Session->read('categoria') === 'administrador'): ?>
        <?php echo $this->Html->link('Editar', '/Alunos/edit/' . $alunos['id']); ?>
    <?php endif; ?>
</p>
</div>

<div class='table-responsive'>
    <div align="center">
        <h2>Estágios cursados</h2>
    </div>
    <table class='table table-striped table-hover table-responsive'>
        <thead class='thead-light'>
            <tr>
        <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <th>Ver</th>
        <?php else: ?>
                <th>Ver</th>
        <?php endif; ?>

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
            <?= $this->Html->link('Ver', '/Estagiarios/view/' . $aluno_estagio['id']); ?>
            <?php else: ?>
            <?= $this->Html->link('Ver', '/Estagiarios/view/' . $aluno_estagio['id']); ?>
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
        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <td>
            <?php echo $this->Html->link('Ver', '/Estagiarios/view/' . $aluno_nao_estagio['id']); ?>
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

    <p>
    <?php if ($this->Session->read('id_categoria') == '1'): ?>
    <?php echo $this->Html->link('Buscar', array('controller' => 'Alunos', 'action' => 'busca')); ?>
    <?php echo " | "; ?>
    <?php echo $this->Html->link("Inserir estágio", array('controller' => 'Estagiarios', 'action' => 'add', $alunos['id'])); ?>
    <?php endif; ?>
    </p>
</div>
