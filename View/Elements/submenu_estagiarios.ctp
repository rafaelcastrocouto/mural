<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Estagiarios", ["controller" => 'estagiarios', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarEstagiarios">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarEstagiarios'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <li class="nav-item"><?= $this->Html->link(__('Estudantes'), ['controller' => 'alunonovos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('E-mails dos estudantes'), ['controller' => 'estagiarios', 'action' => 'email'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('E-mails dos supervisores'), ['controller' => 'estagiarios', 'action' => 'emailsupervisor'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'estagiarios', 'action' => 'add_estagiario'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'alunos', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Não obrigatório'), ['controller' => 'estagiarios', 'action' => 'index?nivel=9'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Retraso ou abandono'), ['controller' => 'estagiarios', 'action' => 'lista'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Error'), ['controller' => 'estagiarios', 'action' => 'alunorfao'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] == 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'estagiarios', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'estagiarios', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => 'Está seguro?', 'class' => 'nav-link']) ?></li>
                <?php endif; ?>
            <?php elseif ($this->Session->read('id_categoria') == '3'): ?>
                <?php if ($this->request->params['action'] == 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'estagiarios', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                <?php endif; ?>
           <?php endif; ?>
        </ul>
    </div>
</nav>
