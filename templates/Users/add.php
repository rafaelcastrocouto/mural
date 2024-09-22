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
                <div class="side-nav">
                    <?php if ($session->read('categoria_id') == 1): ?>
                        <?= $this->Html->link(__('Listar Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                    <?php endif; ?>
                    <?= $this->Html->link(__('Fazer Login'), ['action' => 'login'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Adicionar User') ?></legend>
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
