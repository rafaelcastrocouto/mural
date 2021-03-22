<?php
// pr($folhadeatividades);
// pr($estagiario);
?>

<?= $this->element('submenu_folhadeatividades') ?>

<h2><?= $this->Html->link($estagiario['Aluno']['nome'], ['controller' => 'alunos', 'action' => 'view', $estagiario['Aluno']['id']]) ?></h2>

<div class='row justify-content-center'>
    <div class="col-auto">

        <h2>Estágio</h2>

        <div class="table-responsive">

            <table class='table table-hover table-striped table-responsive'>
                <thead class='thead-light'>
                    <tr>
                        <th>Nível</th>
                        <th>Período</th>
                        <th>Instituição</th>
                        <th>Supervisor</th>
                        <th>Professor(a)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $estagiario['Estagiario']['nivel'] ?></td>
                        <td><?= $estagiario['Estagiario']['periodo'] ?></td>
                        <td><?= $estagiario['Instituicao']['instituicao'] = isset($estagiario['Instituicao']['instituicao']) ? $estagiario['Instituicao']['instituicao'] : 'Sem dados' ?></td>
                        <td><?= $estagiario['Supervisor']['nome'] = isset($estagiario['Supervisor']['nome']) ? $estagiario['Supervisor']['nome'] : "Sem dados" ?></td>
                        <td><?= $estagiario['Professor']['nome'] = isset($estagiario['Professor']['nome']) ? $estagiario['Professor']['nome'] : "Sem dados" ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($folhadeatividades): ?>
    <div class='row justify-content-center'>
        <div class="col-auto">

            <h2>Atividades realizadas</h2>

            <table class="table table-hover table-striped table-responsive">
                <thead class="thead-light">
                    <tr>
                        <th>
                            Atividades no campo de estágio
                        </th>
                        <th>Día</th>
                        <th>Início</th>
                        <th>Final</th>
                        <th>Horas</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $seconds = NULL; ?>
                    <?php foreach ($folhadeatividades as $c_atividade): ?>
                        <tr>
                            <td>
                                <?= $c_atividade['Folhadeatividade']['atividade'] ?>
                            </td>
                            <td>
                                <?= date('d-m-Y', strtotime($c_atividade['Folhadeatividade']['dia'])) ?>
                            </td>
                            <td>
                                <?= $c_atividade['Folhadeatividade']['inicio'] ?>
                            </td>
                            <td>
                                <?= $c_atividade['Folhadeatividade']['final'] ?>
                            </td>
                            <td>
                                <?= $c_atividade['Folhadeatividade']['horario'] ?>
                            </td>
                            <td class="actions">
                                <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $c_atividade['Folhadeatividade']['id'])); ?>
                                <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $c_atividade['Folhadeatividade']['id'])); ?>
                                <?php echo $this->Form->postLink(__('Excluir'), array('action' => 'delete', $c_atividade['Folhadeatividade']['id']), array('confirm' => __('Tem certeza de excluir este registro # %s?', $c_atividade['Folhadeatividade']['id']))); ?>
                            </td>
                        </tr>
                        <?php
                        list($hour, $minute, $second) = array_pad(explode(':', $c_atividade['Folhadeatividade']['horario']), 3, null);
                        $seconds += $hour * 3600;
                        $seconds += $minute * 60;
                        $seconds += $second;
                        // pr($seconds);
                        ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-info">
                        <td colspan="4">Total de horas: </td>
                        <td>
                            <?php
                            $hours = floor($seconds / 3600);
                            $seconds -= $hours * 3600;
                            $minutes = floor($seconds / 60);
                            $seconds -= $minutes * 60;
                            echo $hours . ":" . $minutes . ":" . $seconds;
                            ?>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php endif; ?>

<div class='row justify-content-left'>
    <div class="col">
        <?php echo $this->Form->create('Folhadeatividade', ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <fieldset>
            <legend><?php echo __('Inserir nova atividade'); ?></legend>
            <?php
            echo $this->Form->input('estagiario_id', ['type' => 'hidden', 'value' => $estagiario_id]);
            ?>
            <?php
            echo $this->Form->input('dia', ['type' => 'date', 'monthNames' => $meses, 'dateFormat' => 'DMY', 'label' => ['text' => 'Dia', 'class' => 'col-1'], 'div' => 'form-group row', 'class' => 'form-control', 'between' => '<div class = "form-inline col-11">', 'after' => '</div>']);
            echo $this->Form->input('inicio', ['type' => 'time', 'max' => '24:00', 'label' => ['text' => 'Início', 'class' => 'col-1'], 'div' => 'form-group row', 'class' => 'form-control', 'between' => '<div class = "form-inline col-11">', 'after' => '</div>']);
            echo $this->Form->input('final', ['type' => 'time', 'label' => ['text' => 'Final', 'class' => 'col-1'], 'class' => 'form-control', 'div' => 'form-group row', 'between' => "<div class = 'form-inline col-11'>", 'after' => '</div>']);
            echo $this->Form->input('atividade', ['label' => ['text' => 'Atividade', 'class' => 'col-1'], 'div' => 'form-group row', 'class' => 'form-control col-10', 'between' => "<div class = 'form-inline col-11'>", 'after' => '</div>']);
            ?>
        </fieldset>
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
