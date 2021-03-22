<?php
// pr($folhadeatividades[0])
?>

<?= $this->element('submenu_folhadeatividades') ?>

<?php
$estagio = $folhadeatividades[0];
// pr($estagio);
?>

<div class="row justify-content-center">
<div class='col-auto'>
<h2><?php echo __($this->Html->link($estagio["Estagiario"]["Aluno"]["nome"], ['controller' => 'alunos', 'action' => 'view', $estagio['Estagiario']['id_aluno']])); ?></h2>

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
            <td><?= $estagio['Estagiario']['nivel'] ?></td>
            <td><?= $estagio['Estagiario']['periodo'] ?></td>
            <td><?= $estagio['Estagiario']['Instituicao']['instituicao'] = isset($estagio['Estagiario']['Instituicao']['instituicao']) ? $estagio['Estagiario']['Instituicao']['instituicao'] : 'Sem dados' ?></td>
            <td><?= $estagio['Estagiario']['Supervisor']['nome'] = isset($estagio['Estagiario']['Supervisor']['nome']) ? $estagio['Estagiario']['Supervisor']['nome'] : "Sem dados" ?></td>
            <td><?= $estagio['Estagiario']['Professor']['nome'] = isset($estagio['Estagiario']['Professor']['nome']) ? $estagio['Estagiario']['Professor']['nome'] : "Sem dados" ?></td>
        </tr>
    </tbody>
</table>
</div>
</div>

<div class="row justify-content-center">
<div class='col-auto'>
<table class='table table-hover table-striped table-responsive'>
    <thead class="thead-light">
        <tr>
            <th><?php echo $this->Paginator->sort('dia'); ?></th>
            <th><?php echo $this->Paginator->sort('inicio'); ?></th>
            <th><?php echo $this->Paginator->sort('final'); ?></th>            
            <th><?php echo $this->Paginator->sort('horario', 'Horas'); ?></th>
            <th><?php echo $this->Paginator->sort('atividade'); ?></th>
            <th class="actions"><?php echo __('Ações'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $seconds = NULL; ?>
        <?php foreach ($folhadeatividades as $folhadeatividade): ?>
            <tr>
                <td><?php echo date('d-m-Y', strtotime($folhadeatividade['Folhadeatividade']['dia'])); ?>&nbsp;</td>
                <td><?php echo h($folhadeatividade['Folhadeatividade']['inicio']); ?>&nbsp;</td>
                <td><?php echo h($folhadeatividade['Folhadeatividade']['final']); ?>&nbsp;</td>
                <td><?php echo h($folhadeatividade['Folhadeatividade']['horario']); ?>&nbsp;</td>
                <td><?php echo h($folhadeatividade['Folhadeatividade']['atividade']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $folhadeatividade['Folhadeatividade']['id'])); ?>
                    <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $folhadeatividade['Folhadeatividade']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Excluir'), array('action' => 'delete', $folhadeatividade['Folhadeatividade']['id']), array('confirm' => __('Tem certeza de excluir este registro # %s?', $folhadeatividade['Folhadeatividade']['id']))); ?>
                </td>
            </tr>
            <?php
            list($hour, $minute, $second) = array_pad(explode(':', $folhadeatividade['Folhadeatividade']['horario']), 3, null);
            $seconds += $hour * 3600;
            $seconds += $minute * 60;
            $seconds += $second;
            // pr($seconds);
            ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr class="table-info">
            <td colspan="3">Total de horas: </td>
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
            <td></td>
        </tr>
    </tfoot>
</table>
</div>
</div>
