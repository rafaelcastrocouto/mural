<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Professoras(es)", ["controller" => 'professors', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarProfessores">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarProfessores'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'professors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Pauta'), ['controller' => 'professors', 'action' => 'pauta'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'professors', 'action' => 'busca'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Áreas'), ['controller' => 'areas', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Extensão'), ['controller' => 'extensaos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <?php if (isset($this->params['pass'][0])): ?>
                        <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'professors', 'action' => 'edit/' . $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                        <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'professors', 'action' => 'delete/' . $this->params['pass'][0]], ['confirm' => 'Está seguro?', 'class' => 'nav-link']) ?></li>
                    <?php else: ?> 
                        <?php $siape = isset($this->params['named']['siape']) ? $this->params['named']['siape'] : NULL; ?>
                        <?php
                        if (!$siape) {
                            $siape = $this->request->query("siape");
                        }
                        ?>
                        <?php if ($siape): ?>
                            <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'professors', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                            <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'professors', 'action' => 'delete/', $this->params['pass'][0]], ['confirm' => 'Está seguro?', 'class' => 'nav-link']) ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Professores //-->
            <?php elseif ($this->Session->read('id_categoria') == '3'): ?>
                         <li class="nav-item"><?= $this->Html->link(__('Professoras(es)'), ['controller' => 'professors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                         <li class="nav-item"><?= $this->Html->link(__('Pautas'), ['controller' => 'professors', 'action' => 'pauta'], ['class' => 'nav-link']) ?></li>
                         <li class="nav-item"><?= $this->Html->link(__('Áreas'), ['controller' => 'areas', 'action' => 'index'], ['class' => 'nav-link']) ?></li>                
                <?php if ($this->request->params['action'] == 'view'): ?>
                    <?php if (isset($this->params['pass'][0])): ?>
                            <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'professors', 'action' => 'edit/' . $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <?php else: ?>
                        <?php $siape = isset($this->params['named']['siape']) ? $this->params['named']['siape'] : NULL; ?>
                        <?php
                        if (!$siape) {
                            $siape = $this->request->query("siape");
                        }
                        ?>
                        <?php if ($siape): ?>
                            <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'professors', 'action' => 'edit?siape=' . $siape], ['class' => 'nav-link']) ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Fim de professores -->
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Pautas'), ['controller' => 'professors', 'action' => 'pauta'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Áreas'), ['controller' => 'areas', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php endif; ?>
        </ul>
    </div>
</nav>
