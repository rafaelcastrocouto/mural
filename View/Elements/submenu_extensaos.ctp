<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Extensão", ["controller" => 'extensaos', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarExtensao">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarExtensao'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'extensaos', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'extensaos', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'extensaos', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => __('Are you sure you want to delete # {0}?', $this->params['pass'][0]), 'class' => 'nav-link']) ?></li>              
                <?php endif; ?>
                <li class="nav-item"><?= $this->Html->link(__('Taes'), ['controller' => 'taes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Professoras(es)'), ['controller' => 'professors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Situação PR5'), ['controller' => 'situacaopr5s', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Listar'), ['controller' => 'extensaos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Ver'), ['controller' => 'extensaos', 'action' => 'view', $extensao['Extensao']['id']], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Taes'), ['controller' => 'taes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Professoras(es)'), ['controller' => 'professors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Professoras(es)'), ['controller' => 'situacaopr5s', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php endif; ?>
        </ul>
    </div>
</nav>
