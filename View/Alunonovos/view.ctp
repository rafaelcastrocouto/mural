<div class='table-responsive'>
    
    <?= $this->element('submenu_alunonovos') ?>
    
    <h1>Estudante: <?php echo $alunos['Alunonovo']['nome']; ?></h1>

    <table class='table table-striped table-hover table-responsive'>
        <tr>
            <td style='text-align:left'>Registro: <?php echo $alunos['Alunonovo']['registro']; ?></td>
            <td style='text-align:left'>CPF: <?php echo $alunos['Alunonovo']['cpf']; ?></td>
            <td style='text-align:left'>Cartera de identidade: <?php echo $alunos['Alunonovo']['identidade']; ?></td>
            <td style='text-align:left'>Orgão: <?php echo $alunos['Alunonovo']['orgao']; ?></td>
        </tr>
        <tr style='text-align:left'>
            <td style='text-align:left'>Nascimento: <?php echo date('d-m-Y', strtotime($alunos['Alunonovo']['nascimento'])); ?></td>
            <td style='text-align:left'>Email: <?php echo $alunos['Alunonovo']['email']; ?></td>
            <td style='text-align:left'>Telefone: <?php echo "(".$alunos['Alunonovo']['codigo_telefone'].")".$alunos['Alunonovo']['telefone']; ?></td>
            <td style='text-align:left'>Celular: <?php echo "(".$alunos['Alunonovo']['codigo_celular'].")".$alunos['Alunonovo']['celular']; ?></td>
        </tr>
        <tr>
            <td style='text-align:left'>CEP: <?php echo $alunos['Alunonovo']['cep']; ?></td>
            <td style='text-align:left'>Endereço: <?php echo $alunos['Alunonovo']['endereco']; ?></td>
            <td style='text-align:left'>Bairro: <?php echo $alunos['Alunonovo']['bairro']; ?></td>
            <td style='text-align:left'>Municipio: <?php echo $alunos['Alunonovo']['municipio']; ?></td>
        </tr>
    </table>
</div>

<?php if (($this->Session->read('categoria') === 'estudante') && ($this->Session->read('numero') === $alunos['Alunonovo']['registro'])): ?>
<p>
    <?php echo $this->Html->link('Editar',  '/Alunonovos/edit/' . $alunos['Alunonovo']['id']); ?>
</p>
<?php endif; ?>

<?php if ($inscricoes): ?>

<div align="center">
<h2>Inscrições para seleção de estágio</h2>
</div>

<div class='table-responsive'>
    <table class='table table-striped table-hover table-responsive'>
        <caption style="caption-side: top">Inscrições realizadas</caption>
<?php foreach ($inscricoes as $c_inscricao): ?>
        <tr>

    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <td><?php echo $this->Html->link('X','/Inscricaos/delete/' . $c_inscricao['Inscricao']['id'], NULL, 'Confirma?'); ?></td>
            <td><?php echo $this->Html->link($c_inscricao['Mural']['instituicao'], '/Inscricaos/index/' . $c_inscricao['Mural']['id']); ?></td>
            <td><?php echo $c_inscricao['Mural']['periodo']; ?></td>
    <?php else: ?>
            <td><?php echo $this->Html->link($c_inscricao['Mural']['instituicao'], '/Inscricaos/index/' . $c_inscricao['Mural']['id']); ?></td>
            <td><?php echo $c_inscricao['Mural']['periodo']; ?></td>
    <?php endif; ?>

        </tr>
<?php endforeach; ?>

    </table>
</div>
<?php else: ?>

<h2>Sem inscrições para seleção de estágio!</h2>

<?php endif; ?>


<div align="center">
    <h2>Estágios cursados</h2>
</div>

<div class='table-responsive'>
    <table class='table table-striped table-hover table-responsive'>
        <tr>
        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
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

    <?php foreach ($estagios as $aluno_estagio): ?>
    <?php // pr($aluno_estagio['Estagiario']); ?>
    <?php // die(); ?>
        <tr>
            <td>
                <?php if ($this->Session->read('id_categoria') === '1'): ?>
                    <?= $this->Html->link('Ver', '/Estagiarios/view/' . $aluno_estagio['Estagiario']['id']); ?>
                <?php else: ?>
                    <?= $this->Html->link('Ver', '/Estagiarios/view/' . $aluno_estagio['Estagiario']['id']); ?>
                <?php endif; ?>
            </td>

            <td><?php echo $aluno_estagio['Estagiario']['periodo'] ?></td>
            <td><?php echo $aluno_estagio['Complemento']['periodo_especial'] ?></td>
            <?php if ($aluno_estagio['Estagiario']['nivel'] === '9'): ?>
            <td style='text-align:center'><?php echo 'Não obrigatório'; ?></td>
            <?php else: ?>
            <td style='text-align:center'><?php echo $aluno_estagio['Estagiario']['nivel']; ?></td>
            <?php endif; ?>
            <td style='text-align:center'><?php echo $aluno_estagio['Estagiario']['turno']; ?></td>
            <td style='text-align:center'><?php echo $aluno_estagio['Estagiario']['tc']; ?></td>
            <td><?php echo $this->Html->link($aluno_estagio['Instituicao']['instituicao'], '/Instituicaos/view/' . $aluno_estagio['Estagiario']['id_instituicao']); ?></td>
            <td><?php echo $this->Html->link($aluno_estagio['Supervisor']['nome'], '/Supervisors/view/' . $aluno_estagio['Estagiario']['id_supervisor']); ?></td>
            <td><?php echo $this->Html->link($aluno_estagio['Professor']['nome'], '/Professors/view/' . $aluno_estagio['Estagiario']['id_professor']); ?></td>
            <td><?php echo $this->Html->link($aluno_estagio['Area']['area'], '/Areas/view/' . $aluno_estagio['Estagiario']['id_area']); ?></td>
            <td style='text-align:center'><?php echo $aluno_estagio['Estagiario']['nota']; ?></td>
            <td style='text-align:center'><?php echo $aluno_estagio['Estagiario']['ch']; ?></td>

        </tr>
    <?php endforeach; ?>
    </table>
</div>

<?php if (isset($nao_obrigatorio) && !(empty($nao_obrigatorio))): ?>
<h2>Estágios não obrigatórios</h2>
<div class='table-responsive'>
    <table class='table table-striped table-hover table-responsive'>
        <?php foreach ($nao_obrigatorio as $aluno_nao_estagio): ?>
        <tr>
                <?php if ($this->Session->read('categoria') === 'administrador'): ?>
            <td>
                    <?php echo $this->Html->link('Ver', '/Estagiarios/view/' . $aluno_nao_estagio['Estagiario']['id']); ?>
            </td>
                <?php endif; ?>

            <td><?php echo $aluno_nao_estagio['Estagiario']['periodo'] ?></td>
            <td><?php echo $aluno_estagio['Complemento']['periodo_especial'] ?></td>
            <td style='text-align:center'><?php echo "Não obrigatório"; ?></td>
            <td style='text-align:center'><?php echo $aluno_nao_estagio['Estagiario']['turno']; ?></td>
            <td style='text-align:center'><?php echo $aluno_nao_estagio['Estagiario']['tc']; ?></td>
            <td><?php echo $this->Html->link($aluno_nao_estagio['Instituicao']['instituicao'], '/Instituicaos/view/' . $aluno_nao_estagio['Estagiario']['id_instituicao']); ?></td>
            <td><?php echo $this->Html->link($aluno_nao_estagio['Supervisor']['nome'], '/Supervisors/view/' . $aluno_nao_estagio['Estagiario']['id_supervisor']); ?></td>
            <td><?php echo $this->Html->link($aluno_nao_estagio['Professor']['nome'], '/Professors/view/' . $aluno_estagio['Estagiario']['id_professor']); ?></td>
            <td><?php echo $this->Html->link($aluno_nao_estagio['Area']['area'], '/Areas/view/' . $aluno_nao_estagio['Estagiario']['id_area']); ?></td>
            <td style='text-align:center'><?php echo $aluno_nao_estagio['Estagiario']['nota']; ?></td>
            <td style='text-align:center'><?php echo $aluno_nao_estagio['Estagiario']['ch']; ?></td>

        </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    </table>
</div>
