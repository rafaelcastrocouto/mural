<!-- templates/element/menu_superior.php -->
<ul class="navbar-nav mr-auto">
  <li class="nav-item"><?= $this->Html->link(__('Alunos'), ['controller' => 'alunos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
  <li class="nav-item"><?= $this->Html->link(__('Professores'), ['controller' => 'professores', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
  <li class="nav-item"><?= $this->Html->link(__('Supervisores'), ['controller' => 'supervisores', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
  <li class="nav-item"><?= $this->Html->link(__('Users'), ['controller' => 'users', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
</ul>
