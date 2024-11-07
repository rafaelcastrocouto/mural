<!-- templates/element/submenu_navegacao.php -->
<?php

$categoria_id = 0;
if ($session) { $categoria_id = $session->get('categoria_id'); }

?>

<script>
    const navLoadEvent = event => {
        const navInputs = [...document.querySelectorAll('.toggle-input')];
        const changeEvent = event => {
            navInputs.forEach(inputBox => { if (inputBox !== event.target) inputBox.checked = false; });
        };
        navInputs.forEach(inputBox => { inputBox.addEventListener('change', changeEvent); });
    };
    addEventListener('load', navLoadEvent);
</script>
    
<nav>
    <?php 
        $logo = $this->Html->image('logoess_horizontal-azul.svg', ['height' => '50', 'width' => '150', 'alt' => 'ESS']);
        echo $this->Html->link($logo, "http://www.ess.ufrj.br", ['escape' => false]);
    ?>

    <label for="nav-toggler" class="responsive-toggle-label toggle-icon">☰</label>
    <input id="nav-toggler" type="checkbox" class="toggle-input" />
    
    <menu class="responsive-toggle-dropdown">

        <li><?php echo $this->Html->link("Mural", ['controller' => 'Muralestagios', 'action' => 'index']); ?></li>

        <li class="menu-declaracoes">
            <input id="menu-declaracoes-toggler" type="checkbox" class="toggle-input" />
            <label for="menu-declaracoes-toggler" class="toggle-label">Declarações <span class="toggle-more">▾</span><span class="toggle-less">◂</span></label>
            
            <menu class="toggle-dropdown">
                <li><?php echo $this->Html->link("Termo de compromisso", "/Inscricoes/termosolicita"); ?></li>
                <li><?php echo $this->Html->link("Folha de avaliação discente", "/Alunos/avaliacaosolicita"); ?></li>
                <li><?php echo $this->Html->link("Avaliação discente on-line", "/Avaliacoes/busca_dre"); ?></li>
                <li><?php echo $this->Html->link("Folha de atividades", "/Alunos/folhasolicita"); ?></li>
                <li><?php echo $this->Html->link("Folha de atividades on-line", "/folhadeatividades/busca_dre"); ?></li>

                <?php if ($categoria_id == 1 || $categoria_id == 3 || $categoria_id == 4): ?>
                    <li><?php echo $this->Html->link("Declaração de estágio", "/Alunos/busca_dre"); ?></li>
                <?php else: ?>
                    <li><?php echo $this->Html->link("Declaração de estágio", "/Estagiarios/view?registro="); ?></li>
                <?php endif; ?>
                
            </menu>
        </li>

        <li class="menu-consulta">
            <input id="menu-consulta-toggler" type="checkbox" class="toggle-input" />
            <label for="menu-consulta-toggler" class="toggle-label">Consulta <span class="toggle-more">▾</span><span class="toggle-less">◂</span></label>
            
            <menu class="toggle-dropdown">
        
                <li><?php echo $this->Html->link("Instituições", ['controller' => 'Instituicoes', 'action' => 'index']); ?></li>
                <li><?php echo $this->Html->link("Estagiários", ['controller' => 'Estagiarios', 'action' => 'index']); ?></li>
                <li><?php echo $this->Html->link("Alunos", ['controller' => 'Alunos', 'action' => 'index']); ?></li>
                <li><?php echo $this->Html->link("Professores", ['controller' => 'Professores', 'action' => 'index']); ?></li>
                <li><?php echo $this->Html->link("Supervisores", ['controller' => 'Supervisores', 'action' => 'index']); ?></li>
        
            </menu>
        </li>
        
        <li><?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess'); ?></li>
        
        <?php if ($categoria_id == 1): ?>
            <li class="menu-admin">
                <input id="menu-admin-toggler" type="checkbox" class="toggle-input" />
                <label for="menu-admin-toggler" class="toggle-label">Administração <span class="toggle-more">▾</span><span class="toggle-less">◂</span></label>
                
                <menu class="toggle-dropdown">
                    <li><?php echo $this->Html->link('Configurações', '/Configuracoes'); ?></li>
                    <li><?php echo $this->Html->link('Usuários', '/Users'); ?></li>
                    <li><?php echo $this->Html->link('Planilha seguro', '/Alunos/planilhaseguro/'); ?></li>
                    <li><?php echo $this->Html->link('Planilha CRESS', '/Alunos/planilhacress/'); ?></li>
                    <li><?php echo $this->Html->link('Carga horária', '/Alunos/cargahoraria/'); ?></li>
                    <li><?php echo $this->Html->link('Complemento período', '/Complementos'); ?></li>
                </menu>
            </li>
        <?php else: ?>
            <li><?php echo $this->Html->link('Fale conosco', 'mailto:estagio@ess.ufrj.br'); ?></li>
        <?php endif; ?>

        <li class="menu-user">
            
            <input id="menu-user-toggler" type="checkbox" class="toggle-input" />
            <label for="menu-user-toggler" class="toggle-label">Usuário <span class="toggle-more">▾</span><span class="toggle-less">◂</span></label>
            
            <menu class="toggle-dropdown">
                
                <?php if ($session): ?>
                    <li><?php echo $this->Html->link("Minha conta", ['controller' => 'Users', 'action' => 'view', $session->id]); ?></li>
                <?php endif; ?>
                
                <?php
                switch ($categoria_id) {
                    case 1: // Administrador
                        ?>
                        <li><?php echo $this->Html->link("Meus dados",  ['controller' => 'Administradores', 'action' => 'view', $session->id]); ?></li>
                        <li><?php echo $this->Html->link('Sair', ['controller' => 'Users', 'action' => 'logout']); ?></li>
                        <?php
                        break;
                    case 2: // Aluno
                        ?>
                        <li><?php echo $this->Html->link("Meus dados", "/Alunos/view?registro="); ?></li>
                        <li><?php echo $this->Html->link('Sair', ['controller' => 'Users', 'action' => 'logout']); ?></li>
                        <?php
                        break;
                    case 3: // Professor
                        ?>
                        <li><?php echo $this->Html->link("Meus dados", "/Professores/view?siape="); ?></li>
                        <li><?php echo $this->Html->link('Sair', ['controller' => 'Users', 'action' => 'logout']); ?></li>
                        <?php
                        break;
                    case 4: // Supervisor
                        ?>
                        <li><?php echo $this->Html->link("Meus dados", "/Supervisores/view?cress="); ?></li>
                        <li><?php echo $this->Html->link('Sair', ['controller' => 'Users', 'action' => 'logout']); ?></li>
                        <?php
                        break;
                    default:
                        ?>
                        <li><?php echo $this->Html->link("Login", ['controller' => 'Users', 'action' => 'login']); ?></li>
                    <?php
                }
                ?>
                
            </menu>  
        </li>    
    </menu>
</nav>
