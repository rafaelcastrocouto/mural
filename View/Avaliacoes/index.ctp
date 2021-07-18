<?php
// pr($avaliacoes);
?>
<div class='panel-body'>
    <div class="table-responsive">
        <?= $this->element('submenu_avaliacoes'); ?>

        <h2><?php echo __('Avaliações'); ?></h2>
        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th><?php echo $this->Paginator->sort('id', 'Id'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.Aluno.nome', 'Estudante'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.Instituicao.instituicao', 'Instituicao'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.Professor.nome', 'Docente'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.Supervisor.nome', 'Supervisora(o)'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.nivel', 'Nível'); ?></th>
                    <th><?php echo $this->Paginator->sort('Estagiario.periodo', 'Período'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avaliacoes as $avaliacao): ?>
                <?php // pr($avaliacao['Estagiario']['Supervisor']) ?>
                    <?php if ($this->Session->read('id_categoria') == '4' && isset($avaliacao['Estagiario']['Supervisor']['cress']) == $this->Session->read('numero')): ?>
                        <tr>
                            <td><?php echo h($avaliacao['Avaliacao']['id']); ?>&nbsp;</td>
                            <td>
                                <?php
                                if ($this->Session->read('id_categoria') != '2'):
                                    echo $this->Html->link($avaliacao['Estagiario']['Aluno']['nome'], array('controller' => 'avaliacoes', 'action' => 'view?estagiario_id=' . $avaliacao['Estagiario']['id']));
                                else:
                                    echo $avaliacao['Estagiario']['Aluno']['nome'];
                                endif;
                                ?>
                            </td>
                            <td><?php echo h($avaliacao['Estagiario']['Instituicao']['instituicao']); ?>&nbsp;</td>
                            <td><?php echo $avaliacao['Estagiario']['Professor']['nome'] = isset($avaliacao['Estagiario']['Professor']['nome']) ? $avaliacao['Estagiario']['Professor']['nome'] : 'Sem dados'; ?>&nbsp;</td>
                            <td><?php echo $avaliacao['Estagiario']['Supervisor']['nome'] = isset($avaliacao['Estagiario']['Supervisor']['nome']) ? $avaliacao['Estagiario']['Supervisor']['nome'] : 'Sem dados'; ?>&nbsp;</td>
                            <td><?php echo h($avaliacao['Estagiario']['nivel']); ?>&nbsp;</td>
                            <td><?php echo h($avaliacao['Estagiario']['periodo']); ?>&nbsp;</td>
                        </tr>
                    <?php elseif ($this->Session->read('id_categoria') == '2' && $avaliacao['Estagiario']['registro'] == $this->Session->read('numero')): ?>
                        <tr>
                            <td><?php echo h($avaliacao['Avaliacao']['id']); ?>&nbsp;</td>
                            <td>
                                <?php
                                if ($this->Session->read('id_categoria') != '2'):
                                    echo $this->Html->link($avaliacao['Estagiario']['Aluno']['nome'], array('controller' => 'avaliacoes', 'action' => 'view?estagiario_id=' . $avaliacao['Estagiario']['id']));
                                else:
                                    echo $avaliacao['Estagiario']['Aluno']['nome'];
                                endif;
                                ?>
                            </td>
                            <td><?php echo h($avaliacao['Estagiario']['Instituicao']['instituicao']); ?>&nbsp;</td>
                            <td><?php echo $avaliacao['Estagiario']['Professor']['nome'] = isset($avaliacao['Estagiario']['Professor']['nome']) ? $avaliacao['Estagiario']['Professor']['nome'] : 'Sem dados'; ?>&nbsp;</td>
                            <td><?php echo $avaliacao['Estagiario']['Supervisor']['nome'] = isset($avaliacao['Estagiario']['Supervisor']['nome']) ? $avaliacao['Estagiario']['Supervisor']['nome'] : 'Sem dados'; ?>&nbsp;</td>
                            <td><?php echo h($avaliacao['Estagiario']['nivel']); ?>&nbsp;</td>
                            <td><?php echo h($avaliacao['Estagiario']['periodo']); ?>&nbsp;</td>
                        </tr>
                    <?php elseif ($this->Session->read('id_categoria') == '1'): ?>
                        <tr>
                            <td><?php echo h($avaliacao['Avaliacao']['id']); ?>&nbsp;</td>
                            <td>
                                <?php
                                if ($this->Session->read('id_categoria') != '2'):
                                    echo $this->Html->link($avaliacao['Estagiario']['Aluno']['nome'], array('controller' => 'avaliacoes', 'action' => 'view?estagiario_id=' . $avaliacao['Estagiario']['id']));
                                else:
                                    echo $avaliacao['Estagiario']['Aluno']['nome'];
                                endif;
                                ?>
                            </td>
                            <td><?php echo h($avaliacao['Estagiario']['Instituicao']['instituicao']); ?>&nbsp;</td>
                            <td><?php echo $avaliacao['Estagiario']['Professor']['nome'] = isset($avaliacao['Estagiario']['Professor']['nome']) ? $avaliacao['Estagiario']['Professor']['nome'] : 'Sem dados'; ?>&nbsp;</td>
                            <td><?php echo $avaliacao['Estagiario']['Supervisor']['nome'] = isset($avaliacao['Estagiario']['Supervisor']['nome']) ? $avaliacao['Estagiario']['Supervisor']['nome'] : 'Sem dados'; ?>&nbsp;</td>
                            <td><?php echo h($avaliacao['Estagiario']['nivel']); ?>&nbsp;</td>
                            <td><?php echo h($avaliacao['Estagiario']['periodo']); ?>&nbsp;</td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
            ?>	</p>
        <div class="paging">
            <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
    </div>
</div>