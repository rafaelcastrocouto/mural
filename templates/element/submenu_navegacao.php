<nav class='navbar navbar-expand-lg navbar-light py-0 navbar-fixed-top'>
    <?php $logo = $this->Html->image('logoess_horizontal-azul.svg', ['height' => '50', 'width' => '150', 'alt' => 'ESS']); ?>
    <?= $this->Html->link($logo, "http://www.ess.ufrj.br", ['class' => 'navbar-brand', 'escape' => false]) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrincipal">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class='collapse navbar-collapse' id='navbarPrincipal'>
        <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
                <?php echo $this->Html->link("Mural", ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'nav-link']); ?>
            </li>

            <?php
                $session = $this->request->getSession();
                if ($session->read('categoria_id') == 1):
            ?>

                <li class="nav-item dropdown">
                    <a style='color:white' class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Declarações</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php echo $this->Html->link("Termo de compromisso", "/Inscricoes/termosolicita", ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Folha de avaliação discente", "/Alunos/avaliacaosolicita", ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Formulário de avaliação discente on-line", "/Avaliacoes/busca_dre", ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Folha de atividades", "/Alunos/folhasolicita", ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link("Folha de atividades on-line", "/folhadeatividades/busca_dre", ['class' => 'dropdown-item']); ?>
                        <!-- comment -->                         
                        <?php if ($session->read('categoria_id') == '1'): ?>
                            <?php echo $this->Html->link("Declaração de estágio", "/Alunos/busca_dre", ['class' => 'dropdown-item']); ?>
                        <?php elseif ($session->read('categoria_id') == '2'): ?>
                            <?php echo $this->Html->link("Declaração de estágio", "/Estagiarios/view?registro=" . $this->Session->read('numero'), ['class' => 'dropdown-item']); ?>
                        <?php elseif (($session->read('categoria_id') == '3') || ($this->Session->read('categoria_id') == '4')): ?>
                            <?php echo $this->Html->link("Declaração de estágio", "/Alunos/busca_dre", ['class' => 'dropdown-item']); ?>
                        <?php endif; ?>
                    </div>
                </li>

                <li class="nav-item">
                    <?php echo $this->Html->link("Estagiários", ['controller' => 'Estagiarios', 'action' => 'index'], ['class' => 'nav-link']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Instituições", ['controller' => 'Instituicoes', 'action' => 'index'], ['escape' => FALSE, 'class' => 'nav-link']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Supervisores", ['controller' => 'Supervisores', 'action' => 'index'] , ['class' => 'nav-link']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Professores", ['controller' => 'Professores', 'action' => 'index'], ['class' => 'nav-link']); ?>
                </li>
            <?php endif; ?>

            <?php if ($session->read('categoria_id') == '1'): ?>
                <li class="nav-item dropdown">
                    <a style='color: white' class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administração</a>
                    <div class="dropdown-menu">
                        <?php echo $this->Html->link('Configuração', '/Configuracaos/view/1', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Usuários', '/Users', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Planilha seguro', '/Alunos/planilhaseguro/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Planilha CRESS', '/Alunos/planilhacress/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Carga horária', '/Alunos/cargahoraria/', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Complemento período', '/Complementos', ['class' => 'dropdown-item']); ?>
                        <?php echo $this->Html->link('Extensão', '/Extensaos', ['class' => 'dropdown-item']); ?>
                    </div>
                </li>
            <?php endif; ?>

            <li class = "nav-item">
                <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link']); ?>
            </li>
            <li class = "nav-item">
                <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link']); ?>
            </li>
        </ul>
        <ul class = "navbar-nav ml-auto">
            <?php
            switch ($session->read('categoria_id')) {
                case 1: // Administrador
                    ?>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link']); ?>
                    </li>
                    <?php
                    break;
                case 2: // Aluno
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Alunos/view?registro=" . $this->Session->read('numero'), ['class' => 'nav-link']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link']); ?>
                    </li>
                    <?php
                    break;
                case 3: // Professor
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Professores/view?siape=" . $this->Session->read('numero'), ['class' => 'nav-link', 'style' => 'color: white']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link']); ?>
                    </li>
                    <?php
                    break;
                case 4: // Supervisor
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Supervisores/view?cress=" . $this->Session->read('numero'), ['class' => 'nav-link']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link']); ?>
                    </li>
                    <?php
                    break;
                default:
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Login", ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']); ?>
                    </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>
