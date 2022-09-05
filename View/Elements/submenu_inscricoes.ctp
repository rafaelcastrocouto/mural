<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link('Inscrição para estágio', ["controller" => 'inscricaos', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarInscricao">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarInscricao'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Mural'), ['controller' => 'murals', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Alunos por inscrição'), ['controller' => 'inscricaos', 'action' => 'orfao'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Inscrições sem aluno'), ['controller' => 'murals', 'action' => 'inscricaosemaluno'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'view'): ?>
                    <?php if (isset($this->params['pass'][0])): ?>
                        <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'inscricaos', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                        <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'inscricaos', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <li class="nav-item"><?= $this->Html->link(__('Mural'), ['controller' => 'murals', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php endif; ?>
        </ul>
    </div>
</nav>
