<?php
// pr($mural);
?>
<div class='table-responsive'>
    <?php
    if ($this->Session->read('id_categoria') == '2'):
        if ($this->Session->read('numero') !== null):
            $estagiario = $this->Session->read('estagiario');
            if (($estagiario !== null) && ($estagiario === '1')):
            // echo $this->element("submenu_nav_estudante");
            elseif (($estagiario !== null) && ($estagiario === '0')):
            // echo $this->element("submenu_nav_aluno");
            endif;
        endif;
    elseif ($this->Session->read('id_categoria') == '1'):
        echo $this->element("submenu_mural");
    endif;
    ?>
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
            <tr>
                <td width="20%"></td>
                <td width="80%"></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Instituição</td>
                <?php if ($this->Session->read('id_categoria') === 1): ?>
                    <td><?= $this->Html->link($mural['Mural']['instituicao'], ['controller' => 'Instituicaos', 'action' => 'view', $mural['Mural']['id_estagio']]); ?></td>
                <?php else: ?>
                    <td><?= $mural['Mural']['instituicao']; ?></td>
                <?php endif; ?>
            </tr>

            <tr>
                <td>Convênio</td>
                <td>
                    <?php
                    switch ($mural['Mural']['convenio']) {
                        case 0: $convenio = 'Não';
                            break;
                        case 1: $convenio = 'Sim';
                            break;
                    }
                    echo $convenio;
                    ?>
                </td>
            </tr>

            <tr>
                <td>Período</td>
                <td><?php echo $mural['Mural']['periodo']; ?></td>
            </tr>

            <tr>
                <td>Vagas</td>
                <td><?php echo $mural['Mural']['vagas']; ?></td>
            </tr>

            <tr>
                <td>Benefícios</td>
                <td><?php echo $mural['Mural']['beneficios']; ?></td>
            </tr>

            <tr>
                <td>Final de semana</td>
                <td>
                    <?php
                    switch ($mural['Mural']['final_de_semana']) {
                        case 0: $final_de_semana = 'Não';
                            break;
                        case 1: $final_de_semana = 'Sim';
                            break;
                        case 2: $final_de_semana = 'Parcialmente';
                            break;
                    }
                    echo $final_de_semana;
                    ?>
                </td>
            </tr>

            <tr>
                <td>Carga horária</td>
                <td><?php echo $mural['Mural']['cargaHoraria']; ?></td>
            </tr>

            <tr>
                <td>Requisitos</td>
                <td><?php echo $mural['Mural']['requisitos']; ?></td>
            </tr>

            <tr>
                <td>Área de OTP</td>
                <td><?php echo $mural['Area']['area']; ?></td>
            </tr>

            <tr>
                <td>Professor</td>
                <td><?php echo $mural['Professor']['nome']; ?></td>
            </tr>

            <tr>
                <td>Horário do estágio</td>
                <td>
                    <?php
                    switch ($mural['Mural']['horario']) {
                        case 'D': $horario = 'Diurno';
                            break;
                        case 'N': $horario = 'Noturno';
                            break;
                        case 'A': $horario = 'Ambos';
                            break;
                    }
                    echo $horario;
                    ?>
                </td>
            </tr>

            <tr>
                <td>Inscrições até o dia: </td>
                <?php if (empty($mural['Mural']['dataInscricao'])): ?>
                    <td><?= "s/d"; ?></td>
                <?php else: ?>
                    <td><?php echo date('d-m-Y', strtotime($mural['Mural']['dataInscricao'])); ?></td>
                <?php endif; ?>
            </tr>

            <tr>
                <td>Data da seleção</td>
                <?php if (empty($mural['Mural']['dataSelecao'])): ?>
                    <td><?= 's/d'; ?></td>
                <?php else: ?>
                    <td><?php echo date('d-m-Y', strtotime($mural['Mural']['dataSelecao'])) . " Horário: " . $mural['Mural']['horarioSelecao']; ?></td>
                <?php endif; ?>
            </tr>

            <tr>
                <td>Local da seleção</td>
                <td><?php echo $mural['Mural']['localSelecao']; ?></td>
            </tr>

            <tr>
                <td>Forma de seleção</td>
                <td>
                    <?php
                    switch ($mural['Mural']['formaSelecao']) {
                        case 0: $formaselecao = 'Entrevista';
                            break;
                        case 1: $formaselecao = 'CR';
                            break;
                        case 2: $formaselecao = 'Prova';
                            break;
                        case 3: $formaselecao = 'Outra';
                            break;
                    }
                    echo $formaselecao;
                    ?>
                </td>
            </tr>

            <tr>
                <td>Contatos</td>
                <td><?php echo $mural['Mural']['contato']; ?></td>
            </tr>

            <tr>
                <td>Email</td>
                <td><?php echo $mural['Mural']['email']; ?>
                </td>
            </tr>

            <tr>
                <td>Email enviado (preenchimento automático)</td>
                <td><?php
                    if ($mural['Mural']['datafax']) {
                        echo date('d-m-Y', strtotime($mural['Mural']['datafax']));
                    } else {
                        echo "Email não enviado";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Local de Inscrição</td>
                <td>
                    <?php
                    if (($mural['Mural']['localInscricao']) == 0) {
                        echo "Inscrição no mural da Coordenação de Estágio da ESS";
                    } elseif (($mural['Mural']['localInscricao']) == 1) {
                        echo "Inscrição no mural da Coordenação de Estágio da ESS e na Instituição";
                    }
                    ?></td>
            </tr>

            <tr>
                <td>Outras informações</td>
                <td><?php echo $mural['Mural']['outras']; ?></td>
            </tr>

            <!--
            Para o administrador as inscrições sempre estão abertas
            //-->
            <?php if ($this->Session->read('id_categoria') === 1): ?>

                <tr>
                    <td colspan = '2' class="text-center">
                        <?php echo $this->Html->link('Inscrição', ['controller' => 'inscricaos', 'action' => 'add', $mural['Mural']['id']], ['role' => 'button', 'class' => 'btn btn-primary']); ?>
                    </td>
                </tr>

            <?php elseif (($this->Session->read('id_categoria') == 2) || ($this->Session->read('id_categoria') == 3) || ($this->Session->read('id_categoria') == '4')): ?>
                <!--
                Para os outros usuários as inscrições dependem da data de encerramento
                //-->
                <?php if (date('Y-m-d') <= (date('Y-m-d', strtotime($mural['Mural']['dataInscricao'])))): ?>
                    <!--
                    Se a inscricao e na instituição também tem que fazer inscrição no mural
                    //-->
                    <?php if ($mural['Mural']['localInscricao'] === '1'): ?>

                        <tr>
                            <td colspan = 2>
                                <p class="text-center text-danger">Não esqueça de também fazer inscrição na instituição. Ambas são necessárias!</p>
                            </td>
                        </tr>

                    <?php endif; ?>

                    <tr>
                        <td colspan = 2 class="text-center">
                            <?php echo $this->Html->link('Inscrição', ['controller' => 'inscricaos', 'action' => 'add', $mural['Mural']['id']], ['role' => 'button', 'class' => 'btn btn-primary']); ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan = 2>
                            <p class="text-center text-danger">Inscrições encerradas!</p>
                        </td>
                    </tr>
                <?php endif; ?>

            <?php endif; ?>

        </tbody>
    </table>
</div>
