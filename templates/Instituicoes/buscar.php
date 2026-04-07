<?php 
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao[]|\Cake\Collection\CollectionInterface $instituicoes
 */

declare(strict_types=1);

$instituicao = $this->getRequest()->getQuery('instituicao');
$area = $this->getRequest()->getQuery('area');
$cep = $this->getRequest()->getQuery('cep');
$cnpj = $this->getRequest()->getQuery('cnpj');
$email = $this->getRequest()->getQuery('email');
     
// pr($instituicoes);
// die();
?>


<?= $this->Html->script("jquery.mask.min"); ?>
<script>
    $(document).ready(function () {
        $(".cpf").mask("999.999.999-99");
    });
</script>

<div class="instituicoes busca content">

    <div class="tabset">
        
        <input type="radio" name="tabs" id="tab_insituicao" <?= ($instituicao or (!$area and !$cnpj and !$cep and !$email)) ? 'checked' : '' ?> >
        <label for="tab_insituicao">Busca por instituição</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('instituicao', ['label' => ['text' => 'Digite o nome da instituição'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_area" <?= ($area) ? 'checked' : '' ?> >
        <label for="tab_area">Busca por área</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('area', ['label' => ['text' => 'Digite a área'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_cep" <?= ($cep) ? 'checked' : '' ?> >
        <label for="tab_cep">Busca por CEP</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('cep', ['label' => ['text' => 'Digite o CEP'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_cnpj" <?= ($cnpj) ? 'checked' : '' ?> >
        <label for="tab_cnpj">Busca por CNPJ</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('cnpj', ['label' => ['text' => 'Digite o CNPJ'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_email" <?= ($email) ? 'checked' : '' ?> >
        <label for="tab_email">Busca por email</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('email', ['label' => ['text' => 'Digite o email da instituição'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    
    <?php if (isset($instituicoes)): ?>
    
        <?php if (iterator_count($instituicoes)): ?>
    
        
            <?php if ($instituicao): ?><h3>Resultado da busca para o termo "<?= $instituicao ?>"</h3><?php endif; ?>
            <?php if ($area): ?><h3>Resultado da busca para o termo "<?= $area ?>"</h3><?php endif; ?>
            <?php if ($cep):  ?><h3>Resultado da busca para o CEP <?= $cep ?></h3><?php endif; ?>
            <?php if ($cnpj):  ?><h3>Resultado da busca para o CNPJ <?= $cnpj ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Resultado da busca para o email <?= $email ?></h3><?php endif; ?>
    
            <div class="paginator">
                <?= $this->element('paginator'); ?>
            </div>
            <div class="table_wrap">
                <table>
                    <thead class='thead-light'>
                        <tr>
                            <th><?= $this->Paginator->sort('instituicao', 'Nome'); ?></th>
                            <th><?= $this->Paginator->sort('area', 'Área'); ?></th>
                            <th><?= $this->Paginator->sort('cep', 'CNPJ'); ?></th>
                            <th><?= $this->Paginator->sort('cnpj', 'CNPJ'); ?></th>
                            <th><?= $this->Paginator->sort('email', 'E-mail'); ?></th>
                        </tr>
                    </thead>
                    <?php foreach ($instituicoes as $instituicao): ?>
                        <?php 
                          //pr($instituicao);
                          // die();
                        ?>
                        <tr>
                            <td><?= $this->Html->link($instituicao->instituicao, ['action' => 'view', $instituicao->id]); ?></td>
                            <td><?= $this->Html->link($instituicao->area->area, ['controller' => 'Areas', 'action' => 'view', $instituicao->id]); ?></td>
                            <td><?= $instituicao->cep; ?></td>
                            <td><?= $instituicao->cnpj; ?></td>
                            <td><?= ($instituicao->email) ? $this->Text->autoLinkEmails($instituicao->email) : '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="paginator">
                <?= $this->element('paginator'); ?>
                <?= $this->element('paginator_count'); ?>
            </div>
        
        <?php else: ?>
            <?php if ($instituicao): ?><h3>Nenhum resultado encontrado para o termo "<?= $instituicao ?>"</h3><?php endif; ?>
            <?php if ($area): ?><h3>Nenhum resultado encontrado para o termo "<?= $area ?>"</h3><?php endif; ?>
            <?php if ($cep):  ?><h3>Nenhum resultado encontrado para o DRE <?= $cep ?></h3><?php endif; ?>
            <?php if ($cnpj):  ?><h3>Nenhum resultado encontrado para o CPF <?= $cnpj ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Nenhum resultado encontrado para o email <?= $email ?></h3><?php endif; ?>
        <?php endif; ?>
    
    <?php endif; ?>
</div>
