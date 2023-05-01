<?php
// pr($estudantes);
// die();
?>

<div class='pagination justify-content-center'>
    <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
    <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
</div>

<div class="pagination justify-content-center">
    <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
</div>

<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <h1 class='h2'>Estudantes por inscrições e estágio</h1>

    <table class='table table-hover table-striped table-responsive' id='orfaos'>

        <thead class='thead-light'>
            <tr>
                <?php if ($this->Session->read('id_categoria') === 1): ?>
                    <th><?= $this->Paginator->sort('id', 'Id') ?></th>
                    <th><?= $this->Paginator->sort('registro', 'DRE') ?></th>
                    <th><?= $this->Paginator->sort('nome', 'Estudante') ?></th>
                    <th><?= $this->Paginator->sort('celular', 'Celular') ?></th>
                    <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                    <th><?= $this->Paginator->sort('ingresso', 'Ingresso') ?></th>
                    <th><?= $this->Paginator->sort('inscricao_count', 'Inscrições') ?></th>
                    <th><?= $this->Paginator->sort('estagiario_count', 'Estágios') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudantes as $estudante): ?>
                <?php // pr($estudante) ?>
                <?php // die() ?>
                <tr>
                    <td><?= $estudante['Alunonovo']['id'] ?></td>
                    <td><?= $estudante['Alunonovo']['registro'] ?></td>
                    <td><?= $this->Html->link($estudante['Alunonovo']['nome'], ['controller' => 'alunonovos', 'action' => 'view', $estudante['Alunonovo']['id']]) ?></td>
                    <td><?= $estudante['Alunonovo']['celular'] ?></td>
                    <td><?= $estudante['Alunonovo']['email'] ?></td>
                    <td><?= $estudante['Alunonovo']['ingresso'] ?></td>
                    <?php if ($estudante['Alunonovo']['inscricao_count'] != count($estudante['Inscricao'])): ?> 
                        <td class='bg-warning text-dark'><?= $estudante['Alunonovo']['inscricao_count'] ?></td>
                    <?php else: ?>
                        <td><?= $estudante['Alunonovo']['inscricao_count'] ?></td>                    
                    <?php endif; ?>

                    <?php if ($estudante['Alunonovo']['estagiario_count'] != count($estudante['Estagiario'])): ?> 
                        <td class='bg-warning text-dark'><?= $estudante['Alunonovo']['estagiario_count'] ?></td>
                    <?php else: ?>
                        <td><?= $estudante['Alunonovo']['estagiario_count'] ?></td>                    
                    <?php endif; ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
echo $this->Paginator->counter(array(
    'format' => 'Página %page% de %pages%,
    exibindo %current% registros do %count% total,
    começando no registro %start%, finalizando no %end%'
));
?>

