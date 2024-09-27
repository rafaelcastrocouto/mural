<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?php
$session = $this->request->getSession();
$session->write('categoria_id', 1);
// echo $session->read('categoria_id');
?>

<div>
    <div class="column-responsive column-80">
        <div class="users form content">
            <aside>
                <div class="nav">
                    <?php if ($session->read('categoria_id') == 1): ?>
                        <?= $this->Html->link(__('Listar Usuários'), ['action' => 'index'], ['class' => 'button']) ?>
                    <?php endif; ?>
                    <?= $this->Html->link(__('Fazer Login'), ['action' => 'login'], ['class' => 'button']) ?>
                </div>
            </aside>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <h3><?= __('Adicionando usuário') ?></h3>
                <?php
                    echo $this->Form->control('email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('categoria', ['options' => $categorias, 'value' => '2', 'class' => 'form-control']);
                    echo $this->Form->control('registro');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
