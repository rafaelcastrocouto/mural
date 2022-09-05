<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Mural de estágios", ["controller" => 'murals', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMural">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarMural'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == 1): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'murals', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Inscrições'), ['controller' => 'inscricaos', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Alunos por inscrição'), ['controller' => 'inscricaos', 'action' => 'orfao'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Inscrições sem alunos'), ['controller' => 'murals', 'action' => 'inscricaosemaluno'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'murals', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Form->postLink(__('Excluir'), ['controller' => 'murals', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => 'Está seguro?', 'class' => 'nav-link']) ?></li>
                    <li class='nav-item'></li>
                    <li class="nav-item"><?= $this->Html->link(__('Imprimir cartaz'), ['controller' => 'murais', 'action' => 'publicacartaz', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Publicar no Google'), ['controller' => 'murais', 'action' => 'publicagoogle', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Enviar por e-mail'), ['controller' => 'murais', 'action' => 'emailparainstituicao', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>

                <?php endif; ?>
            <?php else: ?>
            <?php endif; ?>
        </ul>
    </div>
</nav>
