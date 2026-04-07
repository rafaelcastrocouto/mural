<?php 

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor[]|\Cake\Collection\CollectionInterface $supervisores
 */


declare(strict_types=1);

$nome = $this->getRequest()->getQuery('nome');
$cress = $this->getRequest()->getQuery('cress');
$cpf = $this->getRequest()->getQuery('cpf');
$email = $this->getRequest()->getQuery('email');
     
?>

<?= $this->Html->script("jquery.mask.min"); ?>
<script>
    $(document).ready(function () {
        $("#cpf").mask("999999999-99");
    });
</script>

<div class="supervisores busca content">

    <div class="tabset">
        
        <input type="radio" name="tabs" id="tab_nome" <?= ($nome or (!$cress and !$cpf and !$email)) ? 'checked' : '' ?> >
        <label for="tab_nome">Busca por nome</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('nome', ['label' => ['text' => 'Digite o nome do supervisor'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_cress" <?= ($cress) ? 'checked' : '' ?> >
        <label for="tab_cress">Busca por CRESS</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('cress', ['label' => ['text' => 'Digite o CRESS do supervisor'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_cpf" <?= ($cpf) ? 'checked' : '' ?> >
        <label for="tab_cpf">Busca por CPF</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('cpf', ['label' => ['text' => 'Digite o CPF do supervisor'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_email" <?= ($email) ? 'checked' : '' ?> >
        <label for="tab_email">Busca por email</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('email', ['label' => ['text' => 'Digite o email do supervisor'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    
    <?php if (isset($supervisores)): ?>
    
        <?php if (iterator_count($supervisores)): ?>
    
        
            <?php if ($nome): ?><h3>Resultado da busca para o termo "<?= $nome ?>"</h3><?php endif; ?>
            <?php if ($cress):  ?><h3>Resultado da busca para o CRESS <?= $cress ?></h3><?php endif; ?>
            <?php if ($cpf):  ?><h3>Resultado da busca para o CPF <?= $cpf ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Resultado da busca para o email <?= $email ?></h3><?php endif; ?>
    
            <div class="paginator">
                <?= $this->element('paginator'); ?>
            </div>
            <div class="table_wrap">
                <table>
                    <thead class='thead-light'>
                        <tr>
                            <th><?= $this->Paginator->sort('cress', 'CRESS'); ?></th>
                            <th><?= $this->Paginator->sort('nome', 'Nome'); ?></th>
                            <th><?= $this->Paginator->sort('cpf', 'CPF'); ?></th>
                            <th><?= $this->Paginator->sort('email', 'E-mail'); ?></th>
                        </tr>
                    </thead>
                    <?php foreach ($supervisores as $supervisor): ?>
                        <tr>
                            <td><?= $supervisor->cress; ?></td>
                            <td><?= $this->Html->link($supervisor->nome, ['action' => 'view', $supervisor->id]); ?></td>
                            <td><?= $supervisor->cpf; ?></td>
                            <td><?= ($supervisor->user and $supervisor->user->email) ? $this->Text->autoLinkEmails($supervisor->user->email) : '' ?></td>
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
            <?php if ($cress):  ?><h3>Nenhum resultado encontrado para o CRESS <?= $cress ?></h3><?php endif; ?>
            <?php if ($cpf):  ?><h3>Nenhum resultado encontrado para o CPF <?= $cpf ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Nenhum resultado encontrado para o email <?= $email ?></h3><?php endif; ?>
        <?php endif; ?>
    
    <?php endif; ?>
</div>
