<?php 
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $estagiarios
 */

declare(strict_types=1);

$nome = $this->getRequest()->getQuery('nome');
$dre = $this->getRequest()->getQuery('dre');
$cpf = $this->getRequest()->getQuery('cpf');
$email = $this->getRequest()->getQuery('email');
     
// pr($estagiarios);
// die();
?>

<?= $this->Html->script("jquery.mask.min"); ?>
<script>
    $(document).ready(function () {
        $("#cpf").mask("999999999-99");
        $("#registro").mask("999999999");
    });
</script>

<div class="estagiarios busca content">

    <div class="tabset">
        
        <input type="radio" name="tabs" id="tab_nome" <?= ($nome or (!$dre and !$cpf and !$email)) ? 'checked' : '' ?> >
        <label for="tab_nome">Busca por nome</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('nome', ['label' => ['text' => 'Digite o nome do aluno'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_dre" <?= ($dre) ? 'checked' : '' ?> >
        <label for="tab_dre">Busca por DRE</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('dre', ['label' => ['text' => 'Digite o DRE do aluno'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_cpf" <?= ($cpf) ? 'checked' : '' ?> >
        <label for="tab_cpf">Busca por CPF</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('cpf', ['label' => ['text' => 'Digite o CPF do aluno'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_email" <?= ($email) ? 'checked' : '' ?> >
        <label for="tab_email">Busca por email</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('email', ['label' => ['text' => 'Digite o email do aluno'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    
    <?php if (isset($estagiarios)): ?>
    
        <?php if (iterator_count($estagiarios)): ?>
    
        
            <?php if ($nome): ?><h3>Resultado da busca para o termo "<?= $nome ?>"</h3><?php endif; ?>
            <?php if ($dre):  ?><h3>Resultado da busca para o DRE <?= $dre ?></h3><?php endif; ?>
            <?php if ($cpf):  ?><h3>Resultado da busca para o CPF <?= $cpf ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Resultado da busca para o email <?= $email ?></h3><?php endif; ?>
    
            <div class="paginator">
                <?= $this->element('paginator'); ?>
            </div>
            <div class="table_wrap">
                <table>
                    <thead class='thead-light'>
                        <tr>
                            <th><?= $this->Paginator->sort('registro', 'DRE'); ?></th>
                            <th><?= $this->Paginator->sort('nome', 'Nome'); ?></th>
                            <th><?= $this->Paginator->sort('cpf', 'CPF'); ?></th>
                            <th><?= $this->Paginator->sort('email', 'E-mail'); ?></th>
                        </tr>
                    </thead>
                    <?php foreach ($estagiarios as $estagiario): ?>
                        <?php 
                          //pr($estagiario);
                          // die();
                        ?>
                        <tr>
                            <td><?= $this->Html->link((string)$estagiario->aluno->registro, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]); ?></td>
                            <td><?= $this->Html->link($estagiario->aluno->nome, ['action' => 'view', $estagiario->id]); ?></td>
                            <td><?= $estagiario->aluno->cpf; ?></td>
                            <td><?= ($estagiario->aluno->user and $estagiario->aluno->user->email) ? $this->Text->autoLinkEmails($estagiario->aluno->user->email) : '' ?></td>
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
            <?php if ($dre):  ?><h3>Nenhum resultado encontrado para o DRE <?= $dre ?></h3><?php endif; ?>
            <?php if ($cpf):  ?><h3>Nenhum resultado encontrado para o CPF <?= $cpf ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Nenhum resultado encontrado para o email <?= $email ?></h3><?php endif; ?>
        <?php endif; ?>
    
    <?php endif; ?>
</div>
