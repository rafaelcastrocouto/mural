<div class="row">
    <div class='col-lg-4 order-lg-1 order-2'>
        <h5>Login</h5>
        <?= $this->Form->create('User'); ?>
        <div class="form-group">
            <?= $this->Form->input('email', ['label' => 'Email', 'type' => 'text', 'class' => 'form-control']); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('password', ['label' => 'Senha', 'class' => 'form-control']); ?>
        </div>
        <?= $this->Form->input('Login', ['label' => false, 'type' => 'submit', 'class' => 'btn btn-primary position-static']); ?>
        <?= $this->Form->end(); ?>
        <div class="nav nav-tabs justify-content-center">
            <?= $this->Html->link('Esqueceu a senha?', '/Users/cadastro?recadastro=1', ['class' => ['nav-item', 'nav-link']]); ?>
            <?= $this->Html->link('Fazer cadastro', '/Users/cadastro/', ['class' => ['nav-item', 'nav-link']]); ?>
        </div>
    </div>
    <div class='col-lg-8 order-lg-2 order-1'>
        <p>
            Prezadas(os) usuárias(os),
            <br />
            <br />
            Para fazer inscrição para seleção de estágio, assim como também para solicitar o termo de compromisso, é necessário estar <?php echo $this->Html->link('cadastrado', '/users/cadastro/'); ?> como usuária(o) do sistema.
            <br />
            <br />
            As(os) estudantes cadastrados podem, fazer inscrição para seleção de estágio, solicitar <strong>termo de compromisso</strong>, formulário de <strong>avaliação discente</strong> de parte do supervisor, <strong>declaração de estágio</strong>, atualizar a informação sobre seus dados pessoais, assim como também, atualizar informação sobre as instituições campos de estágio da ESS/UFRJ.
            <br />
            <br />
            Supervisores e professores também podem realizar cadastro e contribuir para atualizar dados das instituições, assim como manter atualizada a informação sobre seus dados profissionais. Agora supervisores também podem fazer a <strong>avaliação discente <i>on-line</i></strong>
            <br />
            <br />
            Agora também está disponível para preenchimento <i>on-line</i> a <strong>Folha de atividades!</p>
        <br />
        <br />
        <p style="text-align: right">Coordenação de Estágio</p>
    </div>
</div>