<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Alunos estagiários", ["controller" => 'alunos', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAluno">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarAluno'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'alunos', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'alunos', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__("Estagiários"), ['controller' => 'estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <?php if (isset($this->params['pass'][0])): ?>
                        <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'alunos', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                        <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'alunos', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                    <?php endif; ?>                    
                <?php endif; ?>
            <?php elseif ($this->Session->read('id_categoria') == '2'): ?>
                <?php if ($this->request->params['action'] == 'view'): ?>
                    <?php if (isset($this->params['pass'][0])): ?>
                        <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'alunos', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <?php else: ?>
                        <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'alunos', 'action' => 'edit', '?' => ['registro' => $this->request->query('registro')]], ['class' => 'nav-link']) ?></li>
                    <?php endif; ?>
                <?php endif; ?>
                <li class="nav-item"><?= $this->Html->link(__("Estagiários"), ['controller' => 'estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Estudantes'), ['controller' => 'alunos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'alunos', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Estagiarios'), ['controller' => 'estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
