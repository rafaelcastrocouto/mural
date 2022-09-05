<?php
// pr($alunosnaocadastrados);
// pr($mural);
// die();
?>

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

    <?php
    /* Mostra um menú superior para o estudante diferente segundo seja estagiario ou nao */
    // pr($this->Session->read('id_categoria'));
    if ($this->Session->read('id_categoria') == '2'):
        if ($this->Session->read('numero') !== null):
            // pr($this->Session->read('numero'));
            $estagiario = $this->Session->read('estagiario');
            if (isset($estagiario) && ($estagiario == '1')):
                $this->element('submenu_nav_estudante');
            elseif (isset($estagiario) && ($estagiario == '0')):
                $this->element('submenu_nav_aluno');
            endif;
        endif;
    elseif ($this->Session->read('id_categoria') == '1'):
        echo $this->element("submenu_mural");
    endif;
    ?>

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
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <p>Há <?php echo $total_vagas; ?> vagas de estágio e <?php echo $total_alunos; ?> estudantes buscando estágio (<?php echo $alunos_novos; ?> pela primeira vez e <?php echo $alunos_estagiarios; ?> que mudam de estágio)</p>
            <?php endif; ?>
        </div>
    </div>

    <?php $totalvagas = NULL; ?>
    <?php $totalinscricoes = NULL; ?>

    <div class='pagination justify-content-center'>
        <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
        <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
        <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
        <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
    </div>

    <div class="pagination justify-content-center">
        <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
    </div>

    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
            <tr>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <th><?= $this->Paginator->sort('id', 'Id') ?></th>
                <?php endif; ?>
                <th style="width: 25%"><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('vagas', 'Vagas') ?></th>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <th>Atual</th>
                <?php endif; ?>
                <th>Inscritos</th>
                <th style="width: 25%"><?= $this->Paginator->sort('beneficios', 'Benefícios') ?></th>
                <th><?= $this->Paginator->sort('dataInscricao', 'Encerramento') ?></th>
                <th><?= $this->Paginator->sort('dataSelecao', 'Seleção') ?></th>
                <?php if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '4'): ?>
                    <th><?= $this->Paginator->sort('dataFax', 'Email enviado') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $vagas = NULL; ?>
            <?php $estagiarios = NULL; ?>
            <?php foreach ($mural as $data): ?>
                <?php // pr($data) ?>
                <tr>
                    <?php if ($this->Session->read('id_categoria') == '1'): ?>
                        <td><?php echo $this->Html->link($data['Mural']['id'], '/Murals/view/' . $data['Mural']['id']); ?></td>
                    <?php endif; ?>

                    <?php if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '2' || $this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '4'): ?>
                        <td><?php echo $this->Html->link($data['Mural']['instituicao'], '/Murals/view/' . $data['Mural']['id']); ?></td>
                    <?php else: ?>
                        <td><?php echo $data['Mural']['instituicao']; ?></td>
                    <?php endif; ?>

                    <td style="text-align: center"><?php echo $data['Mural']['vagas']; ?></td>

                    <?php if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '4'): ?>
                        <td style="text-align: center">
                            <?php if (isset($data['Instituicao']['Estagiario']) && sizeof($data['Instituicao']['Estagiario']) === 0): ?>
                                <?php echo 'Sem estagiários'; ?>
                            <?php elseif (isset($data['Instituicao']['Estagiario'])): ?>
                                <?php echo $this->Html->link(sizeof($data['Instituicao']['Estagiario']), '/Estagiarios/index/id_instituicao:' . $data['Mural']['id_estagio'] . '/periodo:' . $data['Mural']['periodo']); ?>
                            <?php else: ?>
                                <?= 'Sem estagiários' ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>

                    <td style="text-align: center">
                        <?php if (isset($data['Inscricao']) && sizeof($data['Inscricao']) == 0): ?>
                            <?php echo 0; ?>
                        <?php else: ?>
                            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                                <?php echo $this->Html->link(sizeof($data['Inscricao']), '/Inscricaos/index/' . $data['Mural']['id']); ?>
                            <?php else: ?>
                                <?php echo sizeof($data['Inscricao']); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>

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

                    <?php if ($this->Session->read('id_categoria') == '1' || $this->Session->read('id_categoria') == '3' || $this->Session->read('id_categoria') == '4'): ?>
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
                <?php
                if (isset($data['Instituicao']['Estagiario'])):
                    $estagiarios = $estagiarios + sizeof($data['Instituicao']['Estagiario']);
                endif;
                ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <td>&nbsp</td>
                <?php endif; ?>
                <td style="text-align: center">Total</td>
                <td style="text-align: center"><?php echo $total_vagas; ?></td>
                <td style="text-align: center"><?php echo $atual; ?></td>
                <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <td style="text-align: center"><?php echo $inscricao; ?></td>
                <?php endif; ?>
            </tr>
        </tfoot>
    </table>

    <?php
    echo $this->Paginator->counter(array(
        'format' => 'Página %page% de %pages%,
    exibindo %current% registros do %count% total,
    começando no registro %start%, finalizando no %end%'
    ));
    ?>

</div>
