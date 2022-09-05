<nav class='navbar navbar-expand navbar-light py-0 navbar-fixed-top' style="background-color: #2b6c9c;">
<?php $logo = $this->Html->image('logoess_horizontal-azul.svg', ['height' => '50', 'width' => '150', 'alt' => 'ESS']); ?>
    <?= $this->Html->link($logo, "http://www.ess.ufrj.br", ['class' => 'navbar-brand', 'style' => 'color: white', 'escape' => false]) ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrincipal">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class='collapse navbar-collapse' id='navbarPrincipal'>
        <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
                <?php echo $this->Html->link("Mural", ['controller' => 'Murals', 'action' => 'index'], ['class' => 'nav-link', 'style' => 'color: white;']); ?>
            </li>

            <?php if ($this->Session->read('categoria')): ?>

                <li class="nav-item dropdown">
                    <a style='color:white' class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Declarações</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php echo $this->Html->link("Termo de compromisso", "/Inscricaos/termosolicita", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                        <?php echo $this->Html->link("Avaliação discente", "/Alunos/avaliacaosolicita", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Formulário de avaliação discente", "/Avaliacoes/busca_dre", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Folha de atividades", "/Alunos/folhadeatividades", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php if ($this->Session->read('categoria') === 'administrador'): ?>
                            <?php echo $this->Html->link("Declaração de estágio", "/Alunos/busca_dre", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php elseif ($this->Session->read('id_categoria') === '2'): ?>
                            <?php echo $this->Html->link("Declaração de estágio", "/Estagiarios/view?registro=" . $this->Session->read('numero'), ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php endif; ?>
                    </div>
                </li>

                <li class="nav-item">
                    <?php echo $this->Html->link("Estagiários", "/Estagiarios/index", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Instituições", "/Instituicaos/lista", ['escape' => FALSE, 'class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Supervisores", "/Supervisors/index/ordem:nome", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Professores", "/Professors/index/", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
            <?php endif; ?>

            <?php if ($this->Session->read('id_categoria') === '1'): ?>
                <li class="nav-item dropdown">
                    <a style='color: white' class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administração</a>
                    <div class="dropdown-menu">
                        <?php echo $this->Html->link('Configuração', '/configuracaos/view/1', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Usuários', '/Users/listausuarios/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Planilha seguro', '/Alunos/planilhaseguro/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Planilha CRESS', '/Alunos/planilhacress/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Carga horária', '/Alunos/cargahoraria/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Complemento período', '/Complementos/index/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Extensão', '/Extensaos/index/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </div>
                </li>
            <?php endif; ?>

            <li class = "nav-item">
                <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>
            <li class = "nav-item">
                <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>
        </ul>
        <ul class = "navbar-nav ml-auto">
            <?php
            switch ($this->Session->read('id_categoria')) {
                case 1: // Administrador
                    ?>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <?php
                    break;
                case 2: // Estudante
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Alunos/view?registro=" . $this->Session->read('numero'), ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <?php
                    break;
                case 3: // Professor
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Professors/view?siape=" . $this->Session->read('numero'), ['class' => 'nav-link', 'style' => 'color: white']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <?php
                    break;
                case 4: // Supervisor
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Supervisors/view?cress=" . $this->Session->read('numero'), ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Users/logout/', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <?php
                    break;
                default:
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Login", ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>
