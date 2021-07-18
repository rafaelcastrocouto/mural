<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Avaliação", ["controller" => 'avaliacoes', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAvaliacoes">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarAvaliacoes'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?> 
                <li class="nav-item"><?= $this->Html->link(__("Avaliações"), ['controller' => 'avaliacoes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <?php endif; ?>            
            <?php if ($this->Session->read('id_categoria') == '4'): ?>
                <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'avaliacoes', 'action' => 'busca_dre'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Buscar'), ['controller' => 'avaliacoes', 'action' => 'busca_dre'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__("Folha de atividades"), ['controller' => 'folhadeatividades', 'action' => 'atividade', '?' => ['estagiario_id' => $this->request->query('estagiario_id')]], ['class' => 'nav-link']) ?></li>
                <!-- View //-->
                <?php if ($this->request->params['action'] == 'view'): ?>
                    <?php if (isset($this->params['pass'][0])) { ?>
                        <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'avaliacoes', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                        <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'avaliacoes', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                        <li class='nav-item'><?= $this->Html->link(__('Imprime PDF'), ['action' => 'imprimepdf', $this->params['pass'][0], 'ext' => 'pdf', 'Avaliacao'], ['class' => 'nav-link']); ?></li>
                    <?php } elseif ($this->request->query('estagiario_id')) {
; ?>
                        <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'avaliacoes', 'action' => 'edit', '?' => ['estagiario_id' => $this->request->query('estagiario_id')]], ['class' => 'nav-link']) ?></li>
                        <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'avaliacoes', 'action' => 'delete?estagiario_id=' . $this->request->query('estagiario_id')], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                        <li class='nav-item'><?= $this->Html->link(__('Imprime PDF'), ['action' => 'imprimepdf', "?" => ["estagiario_id" => $this->request->query('estagiario_id')], 'ext' => 'pdf', 'Avaliacao'], ['class' => 'nav-link']); ?></li> 
                    <?php } ?>    
                <?php endif; ?>
                <!-- Fim de view //-->
<?php else: ?> <!-- Se é um aluno //-->
                <li class="nav-item"><?= $this->Html->link(__('Ver'), ['controller' => 'estagiarios', 'action' => 'view', "?" => ['registro' => $this->Session->read('numero')]], ['class' => 'nav-link']) ?></li>
                <li class='nav-item'><?= $this->Html->link(__('Imprime PDF'), ['action' => 'imprimepdf', "?" => ["estagiario_id" => $this->Session->read('estagiario_id')], 'ext' => 'pdf', 'Avaliacao'], ['class' => 'nav-link']); ?></li>
<?php endif; ?>
        </ul>
    </div>
</nav>
