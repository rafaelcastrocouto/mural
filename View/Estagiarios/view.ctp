<div class="table-responsive">

    <?= $this->element('submenu_estagiarios') ?>

    <?= $this->Html->link('Termo de compromisso', '/Inscricaos/termoimprime?estagiario_id=' . $estagio['Estagiario']['id']. '&tipo_de_estagio=' . $estagio['Estagiario']['complemento_id'], ['role' => 'button', 'class' => 'btn btn-info']); ?>
    <?= $this->Html->link('Folha de atividades', '/folhadeatividades/atividade?estagiario_id=' . $estagio['Estagiario']['id'], ['role' => 'button', 'class' => 'btn btn-info']); ?>
    <?= $this->Html->link('Avaliação discente', '/Avaliacoes/view?estagiario_id=' . $estagio['Estagiario']['id'], ['role' => 'button', 'class' => 'btn btn-info']); ?>
    <?= $this->Html->link('Declaração de estágio', ['action' => 'declaracaoestagiopdf', $estagio['Estagiario']['id'], 'ext' => 'pdf', 'declaracaodeestagio'], ['role' => 'button', 'class' => 'btn btn-info']); ?>

    <?php if ($this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '1'): ?>
        <?= $this->Html->link('Editar e lançar nota', '/estagiarios/edit/' . $estagio['Estagiario']['id'], ['role' => 'button', 'class' => 'btn btn-info']); ?>
    <?php endif; ?>

    <h1>Estágiaria(o): <?php echo $estagio['Aluno']['nome']; ?></h1>

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