<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Modalidade período especial", ["controller" => 'complementos', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarComplementos">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarComplementos'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') != '2'): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'complementos', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Estagiários'), ['controller' => 'estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'complementos', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'complementos', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                <?php endif; ?>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Estagiários'), ['controller' => 'estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>