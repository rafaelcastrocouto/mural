<div class="table-responsive">

    <?= $this->element('submenu_estagiarios') ?>

    <?= $this->Html->link('Declaração de período', ['controller' => 'Alunonovos', 'action' => 'certificadoperiodo', $estagio['Estagiario']['alunonovo_id']], ['role' => 'button', 'class' => 'btn btn-info btn-sm']); ?>
    <?= $this->Html->link('Termo de compromisso', '/Inscricaos/termoimprime?estagiario_id=' . $estagio['Estagiario']['id'], ['role' => 'button', 'class' => 'btn btn-info btn-sm']); ?>
    <?= $this->Html->link('Folha de atividades', '/folhadeatividades/atividade?estagiario_id=' . $estagio['Estagiario']['id'], ['role' => 'button', 'class' => 'btn btn-info btn-sm']); ?>
    <?= $this->Html->link('Avaliação discente', '/Avaliacoes/view?estagiario_id=' . $estagio['Estagiario']['id'], ['role' => 'button', 'class' => 'btn btn-info btn-sm']); ?>
    <?= $this->Html->link('Declaração de estágio', ['action' => 'declaracaoestagiopdf', $estagio['Estagiario']['id'], 'ext' => 'pdf', 'declaracaodeestagio'], ['role' => 'button', 'class' => 'btn btn-info btn-sm']); ?>

    <?php if ($this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '1'): ?>
        <?= $this->Html->link('Editar e lançar nota', '/estagiarios/edit/' . $estagio['Estagiario']['id'], ['role' => 'button', 'class' => 'btn btn-danger btn-sm']); ?>
    <?php endif; ?>
    <?php if ($this->Session->read('id_categoria') == '1'): ?>
        <?= $this->Html->link('Excluir', '/estagiarios/delete/' . $estagio['Estagiario']['id'], ['confirm' => 'Está seguro que quer excluir este registro?', 'role' => 'button', 'class' => 'btn btn-danger btn-sm']); ?>
    <?php endif; ?>


    <h1>Estágiaria(o): <?= $this->Html->link($estagio['Aluno']['nome'], ['controller' => 'Alunonovos', 'action' => 'view', $estagio['Estagiario']['alunonovo_id']]); ?></h1>

    <div class='table-responsive'>
        <table class='table table-striped table-hover table-responsive'>
            <tbody>

                <tr>
                    <td>Id</td>
                    <td><?php echo $estagio['Estagiario']['id_aluno']; ?></td>
                </tr>
                <tr>
                    <td>DRE</td>
                    <td><?php echo $estagio['Estagiario']['registro']; ?></td>
                </tr>
                <tr>
                    <td>Período</td>
                    <td><?php echo $estagio['Estagiario']['periodo']; ?></td>
                </tr>

                <tr>
                    <td>Complemento período especial</td>
                    <td><?php echo $estagio['Complemento']['periodo_especial']; ?></td>
                </tr>

                <tr>
                    <td>Nível</td>
                    <td><?php
                        if ($estagio['Estagiario']['nivel'] == '9'):
                            echo "Não obrigatório";
                        else:
                            echo $estagio['Estagiario']['nivel'];
                        endif;
                        ?></td>
                </tr>

                <tr>
                    <td>Ajuste 2020</td>
                    <td><?php echo $estagio['Estagiario']['ajuste2020'] == 0 ? 'Não' : 'Sim'; ?></td>
                </tr>

                <tr>
                    <td>Turno</td>
                    <td>
                        <?php
                        switch ($estagio['Estagiario']['turno']) {
                            case 'D': echo 'Diurno';
                                break;
                            case 'N': echo 'Noturno';
                                break;
                            case 'I': echo 'Indeterminado';
                                break;
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Solicitação do TC</td>
                    <td>
                        <?php if ($estagio['Estagiario']['tc_solicitacao']): ?>
                            <?php echo date('d-m-Y', strtotime($estagio['Estagiario']['tc_solicitacao'])); ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <td>TC (Devolução do TC)</td>
                    <td>
                        <?php
                        switch ($estagio['Estagiario']['tc']) {
                            case 0: echo "Não";
                                break;
                            case 1: echo "Sim";
                                break;
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Benefícios</td>
                    <td><?php echo ($estagio['Estagiario']['benetransporte'] == 0) ? 'Transporte: Não.' : 'Transporte: Sim.'; ?>
                        <?php echo ($estagio['Estagiario']['benealimentacao'] == 0) ? 'Alimentação: Não.' : 'Alimentação: Sim.'; ?>
                        <?php echo "Bolsa: R$ " . $estagio['Estagiario']['benebolsa']; ?></td>
                </tr>

                <tr>
                    <td>Professor</td>
                    <td><?php echo $estagio['Professor']['nome']; ?></td>
                </tr>

                <tr>
                    <td>Área temática</td>
                    <td><?php echo $estagio['Area']['area']; ?></td>
                </tr>

                <tr>
                    <td>Instituição</td>
                    <td><?php echo $estagio['Instituicao']['instituicao']; ?></td>
                </tr>

                <tr>
                    <td>Supervisor</td>
                    <td><?php echo $estagio['Supervisor']['nome']; ?></td>
                </tr>

                <tr>
                    <td>Nota</td>
                    <td><?php echo $estagio['Estagiario']['nota']; ?></td>
                </tr>

                <tr>
                    <td>Carga horária</td>
                    <td><?php echo $estagio['Estagiario']['ch']; ?></td>
                </tr>

                <tr>
                    <td>Observações</td>
                    <td><?php echo $estagio['Estagiario']['observacoes']; ?></td>
                </tr>

            </tbody>
        </table>
    </div>
</div>