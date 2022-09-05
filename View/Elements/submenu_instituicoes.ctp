<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Instituições", ["controller" => 'instituicaos', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarInstituicoes">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarInstituicoes'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'instituicaos', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Listar'), ['controller' => 'instituicaos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'instituicaos', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Área'), ['controller' => 'areainstituicaos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Natureza'), ['controller' => 'instituicaos', 'action' => 'natureza'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Visitas'), ['controller' => 'visitas', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'instituicaos', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'instituicaos', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => 'Está seguro?', 'class' => 'nav-link']) ?></li>
                <?php endif; ?>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Listar'), ['controller' => 'instituicaos', 'action' => 'lista'], ['class' => 'nav-link']) ?></li>
                <?php endif; ?>
        </ul>
    </div>
</nav>
