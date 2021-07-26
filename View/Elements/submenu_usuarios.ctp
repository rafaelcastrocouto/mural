<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
<?= $this->Html->link("Usuários", ["controller" => 'users', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarUsers">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarUsers'>
        <ul class="navbar-nav mr-auto">
        <?php if ($this->Session->read('id_categoria') == '1'): ?>
          <?php $parametros = $this->request->params['action']; ?>
          <li class="nav-item"><?= $this->Html->link(__('Lista'), ['controller' => 'users', 'action' => 'listausuarios'], ['class' => 'nav-link']) ?></li>
          <li class="nav-item"><?= $this->Html->link(__('Busca por número'), ['controller' => 'users', 'action' => 'busca_numero'], ['class' => 'nav-link']) ?></li>
          <li class="nav-item"><?= $this->Html->link(__('Busca por e-mail'), ['controller' => 'users', 'action' => 'busca_email'   ], ['class' => 'nav-link']) ?></li>
          <li class="nav-item"><?= $this->Html->link(__('Alternar usuário'), ['controller' => 'users', 'action' => 'alternarusuario'], ['class' => 'nav-link']) ?></li>
           <?php if ($this->request->params['action'] == 'view'): ?>       
                  <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'users', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                  <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'users', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => 'Está seguro?', 'class' => 'nav-link']) ?></li>
            <?php endif; ?>
        <?php endif; ?>
        </ul>
    </div>
</nav>
