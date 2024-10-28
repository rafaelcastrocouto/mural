<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrador $nome
 */
$categoria_id = 0;

if ($session) {
    $categoria_id = $session->get('categoria_id');
}
?>
<div>
    <div class="column-responsive column-80">
        <div class="administradores form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Administradores'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $administrador->id],
                        ['confirm' => __('Are you sure you want to delete {0}?', $administrador->nome), 'class' => 'button']
                    ) ?>
                </div>
            </aside>
            <?= $this->Form->create($administrador) ?>
            <fieldset>
                <h3><?= __('Editando Administrador') ?></h3>
                <?php
                    if ($categoria_id == 1):
                       echo $this->Form->control('user_id', ['type' => 'number']); 
                    endif;
                    echo $this->Form->control('nome');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
