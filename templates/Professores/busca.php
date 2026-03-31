<?php 

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */


declare(strict_types=1);

$nome = $this->getRequest()->getQuery('nome');
$siape = $this->getRequest()->getQuery('siape');
$cpf = $this->getRequest()->getQuery('cpf');
$email = $this->getRequest()->getQuery('email');
     
// pr($professores);
// die();
?>

<?= $this->Html->script("jquery.mask.min"); ?>
<script>
    $(document).ready(function () {
        $("#cpf").mask("999999999-99");
    });
</script>

<div class="professores busca content">

    <div class="tabset">
        
        <input type="radio" name="tabs" id="tab_nome" <?= ($nome or (!$siape and !$cpf and !$email)) ? 'checked' : '' ?> >
        <label for="tab_nome">Busca por nome</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('nome', ['label' => ['text' => 'Digite o nome do professor'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_siape" <?= ($siape) ? 'checked' : '' ?> >
        <label for="tab_siape">Busca por SIAPE</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('siape', ['label' => ['text' => 'Digite o SIAPE do professor'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_cpf" <?= ($cpf) ? 'checked' : '' ?> >
        <label for="tab_cpf">Busca por CPF</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('cpf', ['label' => ['text' => 'Digite o CPF do professor'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_email" <?= ($email) ? 'checked' : '' ?> >
        <label for="tab_email">Busca por email</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('email', ['label' => ['text' => 'Digite o email do professor'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    
    <?php if (isset($professores)): ?>
    
        <?php if (iterator_count($professores)): ?>
    
        
            <?php if ($nome): ?><h3>Resultado da busca para o termo "<?= $nome ?>"</h3><?php endif; ?>
            <?php if ($siape):  ?><h3>Resultado da busca para o SIAPE <?= $siape ?></h3><?php endif; ?>
            <?php if ($cpf):  ?><h3>Resultado da busca para o CPF <?= $cpf ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Resultado da busca para o email <?= $email ?></h3><?php endif; ?>
    
            <div class="paginator">
                <?= $this->element('paginator'); ?>
            </div>
            <div class="table_wrap">
                <table>
                    <thead class='thead-light'>
                        <tr>
                            <th><?= $this->Paginator->sort('siape', 'SIAPE'); ?></th>
                            <th><?= $this->Paginator->sort('nome', 'Nome'); ?></th>
                            <th><?= $this->Paginator->sort('cpf', 'CPF'); ?></th>
                            <th><?= $this->Paginator->sort('email', 'E-mail'); ?></th>
                        </tr>
                    </thead>
                    <?php foreach ($professores as $professor): ?>
                        <?php 
                          //pr($professor);
                          // die();
                        ?>
                        <tr>
                            <td><?= $professor->registro; ?></td>
                            <td><?= $this->Html->link($professor->nome, ['action' => 'view', $professor->id]); ?></td>
                            <td><?= $professor->cpf; ?></td>
                            <td><?= ($professor->user and $professor->user->email) ? $this->Text->autoLinkEmails($professor->user->email) : '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="paginator">
                <?= $this->element('paginator'); ?>
                <?= $this->element('paginator_count'); ?>
            </div>
        
        <?php else: ?>
            <?php if ($nome): ?><h3>Nenhum resultado encontrado para o termo "<?= $nome ?>"</h3><?php endif; ?>
            <?php if ($siape):  ?><h3>Nenhum resultado encontrado para o SIAPE <?= $siape ?></h3><?php endif; ?>
            <?php if ($cpf):  ?><h3>Nenhum resultado encontrado para o CPF <?= $cpf ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Nenhum resultado encontrado para o email <?= $email ?></h3><?php endif; ?>
        <?php endif; ?>
    
    <?php endif; ?>
</div>
