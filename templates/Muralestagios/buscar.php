<?php 
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao[]|\Cake\Collection\CollectionInterface $instituicoes
 */

declare(strict_types=1);

$instituicao = $this->getRequest()->getQuery('instituicao');
$requisitos = $this->getRequest()->getQuery('requisitos');
$outras = $this->getRequest()->getQuery('outras');
$cnpj = $this->getRequest()->getQuery('cnpj');
$email = $this->getRequest()->getQuery('email');
     
// pr($instituicoes);
// die();
?>


<?= $this->Html->script("jquery.mask.min"); ?>
<script>
    $(document).ready(function () {
        $(".cnpj").mask("99.999.999/9999-99");
    });
</script>

<div class="muralestagios buscar content">

    <div class="tabset">
        
        <input type="radio" name="tabs" id="tab_insituicao" <?= ($instituicao or (!$requisitos and !$cnpj and !$outras and !$email)) ? 'checked' : '' ?> >
        <label for="tab_insituicao">Busca por instituição</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('instituicao', ['label' => ['text' => 'Digite o nome da instituição'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_requisitos" <?= ($requisitos) ? 'checked' : '' ?> >
        <label for="tab_requisitos">Busca por requisitos</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('requisitos', ['label' => ['text' => 'Digite a área'], 'class' => 'form-control']); ?>
            <?php echo $this->Form->submit('Buscar', ['type' => 'Submit', 'class' => 'button']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        
        <input type="radio" name="tabs" id="tab_outras" <?= ($outras) ? 'checked' : '' ?> >
        <label for="tab_outras">Busca por outras informações</label>
        <div class="tab-content">
            <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
            <?php echo $this->Form->control('outras', ['label' => ['text' => 'Digite o termo de pesquisa'], 'class' => 'form-control']); ?>
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
    
    <?php if (isset($muralestagios)): ?>
    
        <?php if (iterator_count($muralestagios)): ?>
    
        
            <?php if ($instituicao): ?><h3>Resultado da busca para o termo "<?= $instituicao ?>"</h3><?php endif; ?>
            <?php if ($requisitos): ?><h3>Resultado da busca para o termo "<?= $requisitos ?>"</h3><?php endif; ?>
            <?php if ($outras):  ?><h3>Resultado da busca para o termo <?= $outras ?></h3><?php endif; ?>
            <?php if ($cnpj):  ?><h3>Resultado da busca para o CNPJ <?= $cnpj ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Resultado da busca para o email <?= $email ?></h3><?php endif; ?>
    
            <div class="paginator">
                <?= $this->element('paginator'); ?>
            </div>
            <div class="table_wrap">
                <table>
                    <thead class='thead-light'>
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'ID'); ?></th>
                            <th><?= $this->Paginator->sort('instituicao', 'Nome'); ?></th>
                            <th><?= $this->Paginator->sort('requisitos', 'Requisitos'); ?></th>
                            <th><?= $this->Paginator->sort('periodo', 'Período'); ?></th>
                            <th><?= $this->Paginator->sort('cnpj', 'CNPJ'); ?></th>
                            <th><?= $this->Paginator->sort('email', 'E-mail'); ?></th>
                            <th><?= $this->Paginator->sort('outras', 'Outras informações'); ?></th>
                        </tr>
                    </thead>
                    <?php foreach ($muralestagios as $muralestagio): ?>
                        <?php 
                          //pr($muralestagio);
                          // die();
                        ?>
                        <tr>
                            <td><?= $this->Html->link((string)$muralestagio->id, ['action' => 'view', $muralestagio->id]); ?></td>
                            <td><?= ($muralestagio->instituicao) ? $this->Html->link($muralestagio->instituicao->instituicao, ['controller' => 'Instituicao', 'action' => 'view', $muralestagio->instituicao->id]) : ''; ?></td>
                            <td><?= $muralestagio->requisitos; ?></td>
                            <td><?= h($muralestagio->periodo); ?></td>
                            <td class="cnpj"><?= ($muralestagio->instituicao) ? h($muralestagio->instituicao->cnpj) : ''; ?></td>
                            <td><?= ($muralestagio->instituicao && $muralestagio->instituicao->email) ? $this->Text->autoLinkEmails($muralestagio->instituicao->email) : '' ?></td>
                            <td><?= $muralestagio->outras; ?></td>
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
            <?php if ($requisitos): ?><h3>Nenhum resultado encontrado para o termo "<?= $requisitos ?>"</h3><?php endif; ?>
            <?php if ($outras):  ?><h3>Nenhum resultado encontrado para o termo <?= $outras ?></h3><?php endif; ?>
            <?php if ($cnpj):  ?><h3>Nenhum resultado encontrado para o CNPJ <?= $cnpj ?></h3><?php endif; ?>
            <?php if ($email):  ?><h3>Nenhum resultado encontrado para o email <?= $email ?></h3><?php endif; ?>
        <?php endif; ?>
    
    <?php endif; ?>
</div>
