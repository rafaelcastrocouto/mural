
<?php 

$categoria_id = 0;

if ($session) {
    $categoria_id = $session->get('categoria_id');
}

// pr($alunos);
// die();
?>
    
<div>
    <?php echo $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query', 'context']]) ?>
    <?php echo $this->Form->control('nome', ['label' => ['text' => 'Digite o nome do aluno'], 'class' => 'form-control']); ?>
    <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma'], 'class' => 'button']); ?>
    <?php echo $this->Form->end(); ?>
</div>

<?php if (isset($alunos)): ?>

    <h3>Resultado da busca</h3>
    
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead class='thead-light'>
                <tr>
                    <th><?php echo $this->Paginator->sort('registro', 'DRE'); ?></th>
                    <th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>
                    <th><?php echo $this->Paginator->sort('cpf', 'CPF'); ?></th>
                    <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>
                </tr>
            </thead>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?php echo $aluno->registro; ?></td>
                    <td><?php echo $this->Html->link($aluno->nome, ['action' => 'view', $aluno->id]); ?></td>
                    <td><?php echo $aluno->cpf; ?></td>
                    <td><?php echo $aluno->email; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="paginator">
        <?= $this->element('paginator'); ?>
        <?= $this->element('paginator_count'); ?>
    </div>

<?php else: ?>
    <h3>Nenhum resultado</h3>
<?php endif; ?>
