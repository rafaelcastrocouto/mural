<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul class="navbar-nav mr-auto">
  <li class="nav-item"><?= $this->Html->link(__('Alunos'), ['controller' => 'alunos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
  <li class="nav-item"><?= $this->Html->link(__('Responsáveis'), ['controller' => 'atendentes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
  <li class="nav-item"><?= $this->Html->link(__('Taes'), ['controller' => 'taes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
  <li class="nav-item"><?= $this->Html->link(__('Professores'), ['controller' => 'professores', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
  <li class="nav-item"><?= $this->Html->link(__('Demandas'), ['controller' => 'demandas', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
  <li class="nav-item"><?= $this->Html->link(__('Histórico'), ['controller' => 'historicos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
</ul>
