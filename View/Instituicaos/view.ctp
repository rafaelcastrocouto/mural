<?php
// pr($instituicao); 
?>
<div class='container'>
    <div class='row justify-content-left'>
        <?php echo $this->element('submenu_instituicoes'); ?>
    </div>

    <div class='row justify-content-center'>
        <div align="center">
            <?php echo $this->Html->link('Retroceder', array('url' => 'view', $registro_prev)) . " "; ?> |
            <?php echo $this->Html->link('Avançar', array('url' => 'view', $registro_next)); ?>
        </div>

        <table class='table table-responsive table-hover table-striped'>
            <tr>
                <td width="15%">Instituição</td>
                <td width="85%">
                    <?php echo $this->Html->link($instituicao['Instituicao']['instituicao'], '/Estagiarios/index/id_instituicao:' . $instituicao['Instituicao']['id']); ?>
                </td>
            </tr>

            <tr>
                <td>CNPJ</td>
                <td>
                    <?php echo $instituicao['Instituicao']['cnpj']; ?>
                </td>
            </tr>

            <tr>
                <td>Email</td>
                <td>
                    <?php echo $instituicao['Instituicao']['email']; ?>
                </td>
            </tr>

            <tr>
                <td>Página web</td>
                <td>
                    <?php echo $this->Html->link($instituicao['Instituicao']['url'], $instituicao['Instituicao']['url'], ['target' => '_blank', 'escape' => false]); ?>
                </td>
            </tr>

            <tr>
                <td>Convênio com a UFRJ</td>
                <td>
                    <?php
                    if (!empty($instituicao['Instituicao']['convenio'])) {
                        echo $this->Html->link($instituicao['Instituicao']['convenio'], "http://www.pr1.ufrj.br/estagios/info.php?codEmpresa=" . $instituicao['Instituicao']['convenio'],['target' => '_blank', 'escape' => false]);
                    } else {
                        echo "Sem dados";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Data de expiração do convênio</td>
                <td>
                    <?php
                    if (!empty($instituicao['Instituicao']['expira'])) {
                        echo $instituicao['Instituicao']['expira'];
                    } else {
                        echo "Sem dados";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Seguro</td>
                <td>
                    <?php
                    if ($instituicao['Instituicao']['seguro'] == '0'):
                        echo "s/d";
                    else:
                        echo $instituicao['Instituicao']['seguro'];
                    endif;
                    ?>
                </td>
            </tr>

            <tr>
                <td>Última visita</td>
                <td>
                    <?php
                    /* PHP 7.2 */
                    $visitas = (is_array($instituicao['Visita']) ? sizeof($instituicao['Visita']) : 0);
                    /* PHP 7.2 */
                    if ($visitas > 0):
                        $ultimavisita = end($instituicao['Visita']);
                        if ($ultimavisita['data']):
                            if ($this->Session->read('id_categoria') == '2'):
                                echo date('d-m-Y', strtotime($ultimavisita['data']));
                            else:
                                echo $this->Html->link(date('d-m-Y', strtotime($ultimavisita['data'])), '/visitas/view/' . $ultimavisita['id']);
                            endif;
                        else:
                            echo "Sem visita";
                        endif;
                    else:
                        echo "Sem visita";
                    endif;
                    ?>
                </td>
            </tr>

            <tr>
                <td>Área da instituição</td>
                <td>
                    <?php echo $instituicao['Areainstituicao']['area']; ?>
                </td>
            </tr>

            <tr>
                <td>Natureza</td>
                <td>
                    <?php echo $instituicao['Instituicao']['natureza']; ?>
                </td>
            </tr>

            <tr>
                <td>Endereço</td>
                <td>
                    <?php echo $instituicao['Instituicao']['endereco']; ?>
                </td>
            </tr>

            <tr>
                <td>CEP</td>
                <td>
                    <?php echo $instituicao['Instituicao']['cep']; ?>
                </td>
            </tr>

            <tr>
                <td>Bairro</td>
                <td>
                    <?php echo $instituicao['Instituicao']['bairro']; ?>
                </td>
            </tr>

            <tr>
                <td>Município</td>
                <td>
                    <?php echo $instituicao['Instituicao']['municipio']; ?>
                </td>
            </tr>

            <tr>
                <td>Telefone</td>
                <td>
                    <?php echo $instituicao['Instituicao']['telefone']; ?>
                </td>
            </tr>

            <tr>
                <td>Fax</td>
                <td>
                    <?php echo $instituicao['Instituicao']['fax']; ?>
                </td>
            </tr>

            <tr>
                <td>Benefícios</td>
                <td>
                    <?php echo $instituicao['Instituicao']['beneficio']; ?>
            </tr>

            <tr>
                <td>Final de semana</td>
                <td>
                    <?php echo $instituicao['Instituicao']['fim_de_semana']; ?>
                </td>
            </tr>

            <tr>
                <td>Observações</td>
                <td>
                    <?php echo $instituicao['Instituicao']['observacoes']; ?>
                </td>
            </tr>

        </table>

        <?php if ($this->Session->read('id_categoria') == '1'): ?>
            <?php
            echo $this->Html->link('Excluir', ['controller' => 'Instituicaos', 'action' => 'delete', $instituicao['Instituicao']['id'], null, 'Tem certeza?'], ['class' => 'btn btn-danger']);
            echo $this->Html->link('Editar', ['controller' => 'Instituicaos', 'action' => 'edit', $instituicao['Instituicao']['id']], ['class' => 'btn btn-primary']);

            if (sizeof($instituicao['Visita']) == '0') {
                echo $this->Html->link('Visita', ['controller' => 'Visitas', 'action' => 'add', $instituicao['Instituicao']['id']], ['class' => 'btn btn-primary']);
            }
            echo $this->Html->link('Inserir', ['controller' => 'Instituicaos', 'action' => 'add'], ['class' => 'btn btn-primary']);
            echo $this->Html->link('Buscar', ['controller' => 'Instituicaos', 'action' => 'busca'], ['class' => 'btn btn-primary']);
            echo $this->Html->link('Listar', ['controller' => 'Instituicaos', 'action' => 'index'], ['class' => 'btn btn-primary']);
            ?>
        <?php else: ?>
            <?php
            echo $this->Html->link('Editar', ['controller' => 'Instituicaos', 'action' => 'edit', $instituicao['Instituicao']['id'], 'class' => 'btn bnt-primary']);
            echo $this->Html->link('Buscar', ['controller' => 'Instituicaos', 'action' => 'busca', 'class' => 'btn btn-primary']);
            echo $this->Html->link('Listar', ['controller' => 'Instituicaos', 'action' => 'index', 'class' => 'btn btn-primary']);
            ?>
        <?php endif; ?>

    </div>

    <?php
// pr($instituicao['Supervisor']);

    if ($instituicao['Supervisor']) {
        $i = 0;
        foreach ($instituicao['Supervisor'] as $c_supervisor) {

            $cada_supervisor[$i]['nome'] = $c_supervisor['nome'];
            $cada_supervisor[$i]['id'] = $c_supervisor['id'];
            $cada_supervisor[$i]['cress'] = $c_supervisor['cress'];
            $cada_supervisor[$i]['id_superinst'] = $c_supervisor['InstSuper']['id'];
            $i++;
        }
        sort($cada_supervisor);
    }
    ?>

    <?php if (isset($cada_supervisor)): ?>

        <br />
        <hr />

        <div class='table-responsive'>
            <table class='table table-striped table-hover table-responsive'>
                <thead class='thead-light'>
                    <tr>
                        <th>
                            CRESS
                        </th>
                        <th>
                            Nome
                        </th>
                        <?php if ($this->Session->read('id_categoria') == '1'): ?>
                            <th>
                                Ação
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <?php foreach ($cada_supervisor as $c_supervisor): ?>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $c_supervisor['cress']; ?>
                            </td>


                            <td>
                                <?php
                                echo $this->Html->link($c_supervisor['nome'], '/Supervisors/view/' . $c_supervisor['id']);
                                ?>
                            </td>

                            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                                <td>
                                    <?php
                                    echo $this->Html->link('Excluir', ['controller' => 'Instituicaos', 'action' => 'deleteassociacao', $c_supervisor['id_superinst'], null, 'Tem certeza?'], ['class' => 'btn btn-danger']);
                                    ?>
                                </td>
                            <?php endif; ?>

                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>

    <?php endif; ?>

    <hr />

    <div class='table-responsive'>

        <?php if ($this->Session->read('categoria') != 'estudante'): ?>

            <h1>Inserir supervisor</h1>

            <?php
            echo $this->Form->create('Instituicao', array('controller' => 'Instituicaos', 'url' => 'addassociacao'));
            echo $this->Form->input('InstSuper.id_instituicao', array('type' => 'hidden', 'value' => $instituicao['Instituicao']['id']));
            echo $this->Form->input('InstSuper.id_supervisor', array('label' => 'Supervisor', 'options' => $supervisores, 'default' => 0, 'empty' => 'Seleciona', 'class' => 'form-control'));
            echo $this->Form->submit('Confirmar', ['class' => 'btn btn-primary']);
            echo $this->Form->end();
            ?>

        <?php endif; ?>

        <?php if ($instituicao['Estagiario']): ?>
            <!--
            <table>
                <caption>Estagiários</caption>
            <?php foreach ($instituicao['Estagiario'] as $c_estagiario): ?>
                                                                
                <tr>
                    <td><?php echo $this->Html->link($c_estagiario['registro'], '/Estagiarios/view/' . $c_estagiario['id_aluno']); ?></td>
                    <td><?php echo $c_estagiario['id_supervisor']; ?></td>
                    <td><?php echo $c_estagiario['periodo']; ?></td>
                </tr>
                                                                
            <?php endforeach; ?>
            </table>
            //-->
        <?php endif; ?>
    </div>
</div>
