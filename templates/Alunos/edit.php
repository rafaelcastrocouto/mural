<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */

$categoria_id = 0;

if ($session) {
    $categoria_id = $session->get('categoria_id');
}
?>
<div>
    <div class="column-responsive column-80">
        <div class="alunos form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Alunos'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $aluno->id],
                        ['confirm' => __('Are you sure you want to delete {0}?', $aluno->nome), 'class' => 'button']
                    ) ?>
                </div>
            </aside>
            <?= $this->Form->create($aluno) ?>
            <fieldset>
                <h3><?= __('Editando Aluno') ?></h3>
                <?php
                    if ($categoria_id == 1):
                       echo $this->Form->control('user_id', ['type' => 'number']); 
                    endif;
                    echo $this->Form->control('nome');
                    echo $this->Form->control('registro');
                    echo $this->Form->control('codigo_telefone');
                    echo $this->Form->control('telefone');
                    echo $this->Form->control('codigo_celular');
                    echo $this->Form->control('celular');
                    echo $this->Form->control('cpf');
                    echo $this->Form->control('identidade');
                    echo $this->Form->control('orgao');
                    echo $this->Form->control('nascimento', ['empty' => true]);
                    echo $this->Form->control('endereco');
                    echo $this->Form->control('cep');
                    echo $this->Form->control('municipio');
                    echo $this->Form->control('bairro');
                    echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
