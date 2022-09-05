<?php 
// pr($orfaos);
// die();
?>

<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <h2>Alunos novos por inscrições no mural</h2>

        <div class='pagination justify-content-center'>
            <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
            <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
        </div>
        
        <div class="pagination justify-content-center">
            <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
        </div>

        <table class='table table-hover table-striped table-responsive'>

            <thead class='thead-light'>
                <tr>
                    <?php if ($this->Session->read('id_categoria') === 1): ?>
                        <th><?= $this->Paginator->sort('Alunonovo.id', 'Id') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.registro', 'DRE') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.nome', 'Estudante') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.celular', 'Celular') ?></th>
                        <th><?= $this->Paginator->sort('Alunonovo.email', 'Email') ?></th>
                        <th>Inscrições</th>                        
                        <th>Estágios</th>
                    <?php endif; ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($orfaos as $c_orfaos): ?>
                    <tr>

                        <td>
                            <?php echo $c_orfaos['Alunonovo']['id']; ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Alunonovo']['registro']; ?>
                        </td>

                        <td>
                            <?php echo $this->Html->link($c_orfaos['Alunonovo']['nome'], '/alunonovos/view/' . $c_orfaos['Alunonovo']['id']); ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Alunonovo']['celular']; ?>
                        </td>    

                        <td>
                            <?php echo $c_orfaos['Alunonovo']['email']; ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Inscricao'] ? count($c_orfaos['Inscricao']) :  NULL ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['Estagiario'] ? count($c_orfaos['Estagiario']) :  NULL ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
            echo $this->Paginator->counter(array(
                'format' => 'Página %page% de %pages%,
            exibindo %current% registros do %count% total,
            começando no registro %start%, finalizando no %end%'
            ));
        ?>

</div>