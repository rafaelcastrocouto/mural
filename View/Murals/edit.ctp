<?php
if (empty($instituicoes))
    $instituicoes = "Sem dados";
if (empty($areas))
    $areas = "Sem dados";
if (empty($professores))
    $professores = "Sem dados";
?>
<div class="container">
    <div class='row justify-content-left'>
        <div class='col-auto'>
            <?= $this->element("submenu_mural") ?>
            <?php
            echo $this->Form->create('Mural', [
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => [
                    'format' => ['before', 'label', 'between', 'input', 'error', 'after'],
                    'div' => ['class' => 'form-group row'],
                    'label' => ['class' => 'col-4'],
                    'between' => "<div class = 'col-8'>",
                    'class' => ['form-control'],
                    'after' => "</div>",
                    'error' => false
                ]
            ]);
            ?>

            <div class='table-responsive'>
                <table class="table table-striped table-hover table-responsive">
                    <thead class="thead-light">
                        <tr>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php
                                echo $this->Form->input('id', array('type' => 'hidden'));
                                echo $this->Form->input('id_estagio', array('label' => ['text' => 'Instituição', 'class' => 'col-4'], 'type' => 'select', 'options' => $instituicoes));
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php
                                $label = "Convênio";
                                echo $this->Form->input('convenio', array('type' => 'select', 'options' => array('0' => 'Não', '1' => 'Sim')));
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $this->Form->input('periodo', array('type' => 'text')); ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php // echo $this->Form->input('vagas', ['label'=>['text'=>'Vagas (digitar somente números inteiros)', 'class' => 'col-4']);    ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('beneficios'); ?></td>
                        </tr>

                        <tr>
                            <td>
                                <?php
                                echo $this->Form->input('final_de_semana', array('type' => 'select', 'options' => array('0' => 'Não', '1' => 'Sim', '2' => 'Parcialmente')));
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('cargaHoraria'); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('requisitos', array('rows' => 4)); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('id_area', ['type' => 'select', 'options' => $areas, 'label' => ['text' => 'Área de OTP', 'class' => 'col-4']]); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('horario', array('type' => 'select', 'options' => array('D' => 'Diurno', 'N' => 'Noturno', 'A' => 'Ambos'))); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('id_professor', array('label' => ['text' => 'Professor', 'class' => 'col-4'], 'type' => 'select', 'options' => array($professores))); ?></td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $this->Form->input('dataInscricao', array('type' => 'date', 'dateFormat' => 'DMY', 'monthNames' => $meses, 'empty' => TRUE, 'between' => "<div class = 'form-inline col-8'>")); ?>
                            </td>
                            </div
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('dataSelecao', array('type' => 'date', 'dateFormat' => 'DMY', 'monthNames' => $meses, 'empty' => TRUE, "between" => "<div class = 'form-inline col-8'>")); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('horarioSelecao'); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('localSelecao'); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('formaSelecao', array('type' => 'select', 'options' => array('0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outra'))); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('contato'); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('email'); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('datafax', array('type' => 'date', 'dateFormat' => 'DMY', 'monthNames' => $meses, 'label' => ['text' => 'Data de envio do email (preenchimento automático)', 'class' => 'col-4'], 'empty' => TRUE, "between" => "<div class='form-inline col-8'>")); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('localInscricao', array('label' => ['text' => 'Local da inscrição', 'class' => 'col-4'], 'type' => 'select', 'options' => array("0" => 'Mural da Coordenação de Estágio e Extensão/ESS', "1" => 'Diretamente na Instituição'))); ?></td>
                        </tr>

                        <tr>
                            <td><?php echo $this->Form->input('outras', ['label' => ['text' => 'Outras informações', 'class' => 'col-4']]); ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class='row justify-content-center'>
                <div class='col-auto'>
                    <?php
                    echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
                    ?>
                    <?php
                    echo $this->Form->end();
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
