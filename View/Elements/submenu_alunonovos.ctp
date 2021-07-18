<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
<?= $this->Html->link("Estudantes", ["controller" => 'alunonovos', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAlunonovos">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarAlunonovos'>
        <ul class="navbar-nav mr-auto">
        <?php if ($this->Session->read('id_categoria') == '1'): ?>
            <?php $parametros = $this->request->params['action']; ?>
            <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'alunonovos', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'alunonovos', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Alunos em estágio'), ['controller' => 'alunos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php if ($this->request->params['action'] === 'view'): ?>
            <?php if (isset($this->params['pass'][0])): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'alunonovos', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'alunonovos', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                <?php else: ?>
                    <?php
                    $registro = isset($this->params['named']['registro']) ? $this->params['named']['registro'] : NULL;
                    if (!$registro) {
                        $registro = $this->request->query("registro");
                    }
                    if ($registro):
                    ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'alunonovos', 'action' => 'edit?registro=' . $registro], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'alunonovos', 'action' => 'delete?registro=' . $registro], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php elseif ($this->Session->read('id_categoria') != '2'): ?>
            <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'alunonovos', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Estagiarios'), ['controller' => 'estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
        <?php endif; ?>
        </ul>
    </div>
</nav>
