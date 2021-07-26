<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
<?= $this->Html->link("TAE's", ["controller" => 'taes', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTae">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarTae'>
        <ul class="navbar-nav mr-auto">
        <?php if ($this->Session->read('id_categoria') == '1'): ?>
        <?php $parametros = $this->request->params['action']; ?>
        <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'taes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
        <li class="nav-item"><?= $this->Html->link(__('Extensão'), ['controller' => 'extensaos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<!--
          <?php if (isset($tae['Tae']['id'])): ?>
            <li class="nav-item"><?= $this->Html->link(__('Ver'), ['controller' => 'taes', 'action' => 'view', $tae['Tae']['id']], ['class' => 'nav-link']) ?></li>
          <?php endif; ?>
//-->
          <?php if ($parametros === 'view' && isset($tae['Tae']['id'])): ?>
                <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'taes', 'action' => 'edit', $tae['Tae']['id']], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'taes', 'action' => 'delete', $tae['Tae']['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $tae['Tae']['id']), 'class' => 'nav-link']) ?></li>
          <?php endif; ?>
        <?php else: ?>
            <li class="nav-item"><?= $this->Html->link(__('Extensão'), ['controller' => 'extensaos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Ver'), ['controller' => 'taes', 'action' => 'view', $tae['Tae']['id']], ['class' => 'nav-link']) ?></li>
        <?php endif; ?>
        </ul>
    </div>
</nav>
