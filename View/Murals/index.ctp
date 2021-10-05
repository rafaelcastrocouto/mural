<?php ?>

<script>
    $(document).ready(function () {

        var url = "<?= $this->Html->url(['controller' => 'Murals', 'action' => 'index/periodo:']); ?>";

        $("#MuralPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = url + periodo;
        })

    })
</script>

<div class='table-responsive'>

    <?= $this->element("submenu_mural"); ?>

    <div class="row justify-content-center">
        <div class="col-auto">

            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <?php echo $this->Form->create('Mural', ['class' => 'form-inline']); ?>
                <?php echo $this->Form->input('periodo', array('type' => 'select', 'label' => ['text' => 'Mural de estágios da ESS/UFRJ&nbsp', 'style' => 'display: inline;'], 'options' => $todos_periodos, 'default' => $periodo, 'class' => 'form-control')); ?>
                <?php echo $this->Form->end(); ?>
            <?php else: ?>
                <h1 style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?php echo $periodo; ?></h1>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-auto">
            <p>Há <?php echo $total_vagas; ?> vagas de estágio e <?php echo $total_alunos; ?> estudantes buscando estágio (<?php echo $alunos_novos; ?> pela primeira vez e <?php echo $alunos_estagiarios; ?> que mudam de estágio)</p>
        </div>
    </div>

    <?php $totalvagas = NULL; ?>
    <?php $totalinscricoes = NULL; ?>

    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
            <tr>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <th>Id</th>
                <?php endif; ?>
                <th style="width: 25%">Instituição</th>
                <th>Vagas</th>
                <th>Atual</th>
                <th>Inscritos</th>
                <th style="width: 25%">Benefícios</th>
                <th>Encerramento</th>
                <th>Seleção</th>
                <?php if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '4'): ?>
                    <th>Email enviado</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mural as $data): ?>
                <tr>
                    <?php if ($this->Session->read('id_categoria') == '1'): ?>
                        <td><?php echo $this->Html->link($data['Mural']['id'], '/Murals/view/' . $data['Mural']['id']); ?></td>
                    <?php endif; ?>
                    <td><?php echo $this->Html->link($data['Mural']['instituicao'], '/Murals/view/' . $data['Mural']['id']); ?></td>
                    <td style="text-align: center"><?php echo $data['Mural']['vagas']; ?></td>
                    <?php if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '4'): ?>
                        <td style="text-align: center"><?php echo $this->Html->link($data['Mural']['estagiarios'], '/Estagiarios/index/id_instituicao:' . $data['Mural']['id_estagio'] . '/periodo:' . $data['Mural']['periodo']); ?></td>
                        <td style="text-align: center"><?php echo $this->Html->link($data['Mural']['inscricoes'], '/Inscricaos/index/' . $data['Mural']['id']); ?></td>
                    <?php else: ?>
                        <td style="text-align: center"><?php echo $data['Mural']['estagiarios']; ?></td>
                        <td style="text-align: center"><?php echo $data['Mural']['inscricoes']; ?></td>
                    <?php endif; ?>

                    <td><?php echo $data['Mural']['beneficios']; ?></td>

                    <td>
                        <?php
                        if (empty($data['Mural']['dataInscricao'])) {
                            echo "Sem data";
                        } else {
                            echo date('d-m-Y', strtotime($data['Mural']['dataInscricao']));
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if (empty($data['Mural']['dataSelecao'])) {
                            echo "Sem data";
                        } else {
                            echo date('d-m-Y', strtotime($data['Mural']['dataSelecao'])) . " Horário: " . $data['Mural']['horarioSelecao'];
                        }
                        ?>
                    </td>
                    <?php if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '4'):; ?>
                        <td>
                            <?php
                            if (empty($data['Mural']['datafax'])) {
                                echo "Sem data";
                            } else {
                                echo date('d-m-Y', strtotime($data['Mural']['datafax']));
                            }
                            ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td style="text-align: center">Total: </td>
                <td style="text-align: center"><?php echo $total_vagas; ?></td>
                <td style="text-align: center"><?php echo $total_estagiarios; ?></td>
            </tr>
        </tfoot>
    </table>
</div>

