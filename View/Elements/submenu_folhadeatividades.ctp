<nav class="nav nav-tabs navbar-expand-lg navbar-light bg-light">
    <?= $this->Html->link("Folha de atividades", ["controller" => 'folhadeatividades', 'action' => 'index?registro=' . $this->Session->read('numero')], ['class' => 'navbar-brand']) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAtividades">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarAtividades'>
        <ul class="navbar-nav mr-auto">
            <?php if ($this->Session->read('id_categoria') == '1'): ?>
                <?php $parametros = $this->request->params['action']; ?>
                <li class="nav-item"><?= $this->Html->link(__('Folha de atividades'), ['controller' => 'folhadeatividades', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Estagiarios'), ['controller' => 'estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'atividade'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'folhadeatividades', 'action' => 'addatividade', "?" => ['estagiario_id' => $this->Session->read('estagiario_id')]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Imprimir PDF'), ['controller' => 'folhadeatividades', 'action' => 'imprimepdf', '?' => ['estagiario_id' => $this->Session->read('estagiario_id')], 'ext' => 'pdf', 'atividadesdeestagio'], ['class' => 'nav-link']) ?></li>
                <?php endif; ?>
            <?php elseif ($this->Session->read('id_categoria') == '2'): ?>
                <li class="nav-item"><?= $this->Html->link(__('Meus estágios'), ['controller' => 'alunos', 'action' => 'view?registro=' . $this->Session->read('numero')], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Atividades'), ['controller' => 'folhadeatividades', 'action' => 'atividade?estagiario_id=' . $this->Session->read('estagiario_id')], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Imprimir PDF'), ['controller' => 'folhadeatividades', 'action' => 'imprimepdf', '?' => ['estagiario_id' => $this->Session->read('estagiario_id')], 'ext' => 'pdf', 'atividadesdeestagio'], ['class' => 'nav-link']) ?></li>
                <?php if ($this->request->params['action'] === 'atividade'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Inserir'), ['controller' => 'folhadeatividades', 'action' => 'addatividade?estagiario_id=' . $this->Session->read('estagiario_id')], ['class' => 'nav-link']) ?></li>
                <?php elseif ($this->request->params['action'] === 'view'): ?>
                    <li class="nav-item"><?= $this->Html->link(__('Editar'), ['controller' => 'folhadeatividades', 'action' => 'edit', $this->params['pass'][0]], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link(__('Excluir'), ['controller' => 'folhadeatividades', 'action' => 'delete', $this->params['pass'][0]], ['confirm' => __('Confirma?'), 'class' => 'nav-link']) ?></li>
                    <?php endif; ?>
            <?php elseif ($this->Session->read('id_categoria') == '3'): ?>
                <li class="nav-item"><?= $this->Html->link(__('Estudante'), ['controller' => 'estagiarios', 'action' => 'view/' . $this->Session->read('estagiario_id')], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Imprimir PDF'), ['controller' => 'folhadeatividades', 'action' => 'imprimepdf', '?' => ['estagiario_id' => $this->Session->read('estagiario_id')], 'ext' => 'pdf', 'atividadesdeestagio'], ['class' => 'nav-link']) ?></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
