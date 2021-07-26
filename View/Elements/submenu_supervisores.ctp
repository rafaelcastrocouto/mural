<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Supervisores", ["controller" => 'supervisors', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupervisores">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarSupervisores'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'supervisors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'supervisors', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Repetidos'), ['controller' => 'supervisors', 'action' => 'repetidos'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Sem estagiários'), ['controller' => 'supervisors', 'action' => 'semalunos'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__("Avaliações"), ['controller' => 'avaliacoes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'supervisors', 'action' => 'edit/' . $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'supervisors', 'action' => 'delete/' . $this->params['pass'][0]], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                <?php endif; ?>
            <?php elseif ($this->Session->read('id_categoria') == '4'): ?>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'supervisors', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'supervisors', 'action' => 'edit?cress=' . $this->Session->read('numero')], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__("Avaliações"), ['controller' => 'avaliacoes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'supervisors', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__("Avaliações"), ['controller' => 'avaliacoes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php endif; ?>
        </ul>
    </div>
</nav>
