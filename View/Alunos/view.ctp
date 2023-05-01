<?php
// pr($alunos);
// pr($estagios);
// pr($c_estagios);
// pr($nao_obrigatorio);
// pr($estagiario);
?>
<div class='container'>
    <?= $this->element('submenu_alunos'); ?>

    <?php if ($this->Session->read('id_categoria') == '1'): ?>
        <?php echo $this->Html->link('Alunos', '/Alunos/index', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Estagiários', '/Estagiarios/index', ['role' => 'button', 'class' => 'btn btn-info']); ?>
        <?php echo $this->Html->link('Usuários', '/Users/listausuarios', ['role' => 'button', 'class' => 'btn btn-info']); ?>
    <?php endif; ?>

    <div class="row justify-content-left">
        <div class='col-auto'>
            <?php if ($estagiario['Aluno']['nomesocial']): ?>
                <h2>
                    <?php echo $estagiario['Aluno']['nome'] . " - Nome social: " . $estagiario['Aluno']['nomesocial']; ?>
                </h2>
                <h2>
                    <?php echo "Ingresso: " . $estagiario['Aluno']['ingresso'] . " - " . " Turno: " . $estagiario['Aluno']['turno']; ?>
                </h2>
            <?php else: ?>
                <h2>
                    <?php echo $estagiario['Aluno']['nome']; ?>
                </h2>
                <h2 class="h4">
                    <?php echo "Ingresso: " . $estagiario['Aluno']['ingresso'] . " - " . " Turno: " . $estagiario['Aluno']['turno']; ?>
                </h2>
            <?php endif; ?>
        </div>
    </div>

    <table class='table table-striped table-hover table-responsive'>
        <tr>
            <td style='text-align:left'>Registro:
                <?php echo $estagiario['Aluno']['registro']; ?>
            </td>
            <td style='text-align:left'>CPF:
                <?php echo $estagiario['Aluno']['cpf']; ?>
            </td>
            <td style='text-align:left'>Carteira de identidade:
                <?php echo $estagiario['Aluno']['identidade']; ?>
            </td>
            <td style='text-align:left'>Orgão:
                <?php echo $estagiario['Aluno']['orgao']; ?>
            </td>
        </tr>
        <tr>
            <td style='text-align:left'>Nascimento:
                <?php echo isset($estagiario['Aluno']['nascimento']) ? date('d-m-Y', strtotime($estagiario['Aluno']['nascimento'])) : 'Sem dados'; ?>
            </td>
            <td style='text-align:left'>Email:
                <?php echo $estagiario['Aluno']['email']; ?>
            </td>
            <td style='text-align:left'>Telefone:
                <?php echo "(" . $estagiario['Aluno']['codigo_telefone'] . ")" . $estagiario['Aluno']['telefone']; ?>
            </td>
            <td style='text-align:left'>Celular:
                <?php echo "(" . $estagiario['Aluno']['codigo_celular'] . ")" . $estagiario['Aluno']['celular']; ?>
            </td>
        </tr>
        <tr>
            <td style='text-align:left'>Endereço:
                <?php echo $estagiario['Aluno']['endereco']; ?>
            </td>
            <td style='text-align:left'>Bairro:
                <?php echo $estagiario['Aluno']['bairro']; ?>
            </td>
            <td style='text-align:left'>Municipio:
                <?php echo $estagiario['Aluno']['municipio']; ?>
            <td style='text-align:left'>CEP:
                <?php echo $estagiario['Aluno']['cep']; ?>
            </td>
        </tr>
    </table>

    <p>
        <?php if ($this->Session->read('id_categoria') == '1'): ?>
            <?php echo $this->Html->link('Excluir', '/Alunos/delete/' . $estagiario['Aluno']['id'], ['Tem certeza que quer excluir este registro?', 'role' => 'button', 'class' => 'btn btn-danger']); ?>
        <?php endif; ?>

        <?php if (($this->Session->read('id_categoria') == '2') && ($this->Session->read('numero') == $estagiario['Aluno']['registro'])): ?>
            <?php echo $this->Html->link('Editar', '/Alunos/edit/' . $estagiario['Aluno']['id'], ['role' => 'button', 'class' => 'btn btn-danger']); ?>
        <?php elseif ($this->Session->read('id_categoria') == '1'): ?>
            <?php echo $this->Html->link('Editar', '/Alunos/edit/' . $estagiario['Aluno']['id'], ['role' => 'button', 'class' => 'btn btn-danger']); ?>
        <?php endif; ?>
    </p>
</div>

<div class='container'>
    <?php if ($estagiario['Estagiario']): ?>

        <div class='table-responsive'>
            <div class="justify-content-center">
                <h2 class='h2'>Estágios cursados</h2>
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
                <?php foreach ($estagiario['Estagiario'] as $aluno_estagio): ?>
                    <?php // pr($aluno_estagio) ?>
                    <?php if ($aluno_estagio['ajuste2020'] == '0'): ?>
                        <?php $cargaHoraria = '120'; ?>
                    <?php elseif ($aluno_estagio['ajuste2020'] == '1'): ?>
                        <?php $cargaHoraria = '135'; ?>
                    <?php endif; ?>
                    <?php if (($aluno_estagio['nota'] < '5') || ($aluno_estagio['ch'] < $cargaHoraria)): ?>
                        <tr class='bg-warning'>
                        <?php else: ?>
                        <tr>
                        <?php endif; ?>
                        <td>
                            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                                <?= $this->Html->link('Ver', '/Estagiarios/view/' . $aluno_estagio['id']); ?>
                            <?php else: ?>
                                <?= $this->Html->link('Ver', '/Estagiarios/view/' . $aluno_estagio['id']); ?>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= $aluno_estagio['periodo'] ?>
                        </td>
                        <td>
                            <?= $aluno_estagio['complemento_id'] ?>
                        </td>
                        <td style='text-align:center'>
                            <?= $aluno_estagio['nivel'] == 9 ? "Não obrigatório" : $aluno_estagio['nivel']; ?>
                        </td>
                        <td style='text-align:center'>
                            <?= $aluno_estagio['turno']; ?>
                        </td>
                        <td style='text-align:center'>
                            <?= $aluno_estagio['tc']; ?>
                        </td>
                        <td>
                            <?= isset($aluno_estagio['Instituicao']['instituicao']) ? $this->Html->link($aluno_estagio['Instituicao']['instituicao'], '/Instituicaos/view/' . $aluno_estagio['Instituicao']['id']) : NULL; ?>
                        </td>
                        <td>
                            <?= isset($aluno_estagio['Supervisor']['nome']) ? $this->Html->link($aluno_estagio['Supervisor']['nome'], '/Supervisors/view/' . $aluno_estagio['Supervisor']['id']) : NULL; ?>
                        </td>
                        <td>
                            <?= isset($aluno_estagio['Professor']['nome']) ? $this->Html->link($aluno_estagio['Professor']['nome'], '/Professors/view/' . $aluno_estagio['Professor']['id']) : NULL; ?>
                        </td>
                        <td>
                            <?= isset($aluno_estagio['Area']['area']) ? $this->Html->link($aluno_estagio['Area']['area'], '/Areas/view/' . $aluno_estagio['Area']['id']) : NULL; ?>
                        </td>
                        <td style='text-align:center'>
                            <?= $aluno_estagio['nota']; ?>
                        </td>
                        <td style='text-align:center'>
                            <?= $aluno_estagio['ch']; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    <?php endif; ?>

    <p>
        <?php if ($this->Session->read('id_categoria') == '1'): ?>
            <?php echo $this->Html->link("Inserir estágio", ['controller' => 'Estagiarios', 'action' => 'add', $estagiario['Aluno']['id']], ['role' => 'button', 'class' => 'btn btn-success']); ?>
        <?php endif; ?>
    </p>
</div>