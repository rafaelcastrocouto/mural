<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Áreas das(os) professoras(os)", ["controller" => 'areas', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAreas">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarAreas'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'areas', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Lista'), ['controller' => 'areas', 'action' => 'lista'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Professores'), ['controller' => 'professors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'areas', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'areas', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => 'Está seguro?', 'class' => 'nav-link']) ?></li>
                <?php endif; ?>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Professoras(es)'), ['controller' => 'professors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php endif; ?>
        </ul>
    </div>
</nav>
