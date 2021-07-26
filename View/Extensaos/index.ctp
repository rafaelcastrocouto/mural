<?php

// pr($extensaos);

?>
<?php // die();        ?>

<div class='row justify-content-center'>
    <div class='col-auto'>

        <?= $this->element('submenu_extensaos') ?>

        <h2><?php echo __('Extensão'); ?></h2>

        <div class='pagination justify-content-center'>
            <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
            <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
        </div>

        <div class="pagination justify-content-center">
            <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
        </div>

        <table class='table table-striped table-hover table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th><?php echo $this->Paginator->sort('id', 'Id'); ?></th>
                    <th><?php echo $this->Paginator->sort('titulo', 'Título'); ?></th>
                    <th><?php echo $this->Paginator->sort('segmento', 'Segmento'); ?></th>
                    <th><?php echo $this->Paginator->sort('nome', 'Coordenador[a]'); ?></th>
                    <th><?php echo $this->Paginator->sort('datacongregacao', 'Congregação'); ?></th>
                    <th><?php echo $this->Paginator->sort('versao', 'Versão'); ?></th>
                    <th><?php echo $this->Paginator->sort('Situacaopr5.situacao', 'Situação PR5'); ?></th>                    
                    <th><?php echo $this->Paginator->sort('observacoes', 'Observações'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($extensaos as $extensao): ?>
                <?php // pr($extensao); ?>
                <tr>
                    <td><?php echo h($extensao['Extensao']['id']); ?>&nbsp;</td>
                    <td><?php echo $this->Html->link($extensao['Extensao']['titulo'], ['controller' => 'extensaos', 'action' => 'view', $extensao['Extensao']['id']]); ?>&nbsp;</td>
                    <td><?php echo $this->Html->link(h($extensao['Extensao']['segmento']), ['controller' => 'extensaos', 'action' => 'view', $extensao['Extensao']['id']]); ?>&nbsp;</td>
                    <td>
                            <?php
                            if ($extensao['Extensao']['segmento'] === 'tae'):
                                echo $this->Html->link($extensao['Extensao']['nome'], array('controller' => 'taes', 'action' => 'view', $extensao['Extensao']['tae_id']));
                            elseif ($extensao['Extensao']['segmento'] === 'docente'):
                                echo $this->Html->link($extensao['Extensao']['nome'], array('controller' => 'professors', 'action' => 'view', $extensao['Extensao']['docente_id']));
                            endif;
                            ?>
                    </td>
                    <td><?php
                            if ($extensao['Extensao']['datacongregacao']):
                                echo date('d-m-Y', strtotime($extensao['Extensao']['datacongregacao']));
                            endif;
                            ?>&nbsp;
                    </td>
                    <td><?php echo h($extensao['Extensao']['versao']); ?>&nbsp;</td>
                    <td><?php echo h($extensao['Situacaopr5']['situacao']); ?>&nbsp;</td>                    
                    <td><?php echo h($extensao['Extensao']['observacoes']); ?>&nbsp;</td>
                </tr>
<?php endforeach; ?>
            </tbody>

        </table>
    </div>

    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>
    </p>

</div>
