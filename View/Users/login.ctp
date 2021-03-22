<?php ?>
<div class = 'table-responsive'>

    <?php
    echo $this->Form->create('User', array(
        'inputDefaults' => array(
            'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-4'],
            'between' => '<div class = col-8>',
            'class' => ['form-control'],
            'after' => '</div>',
            'error' => false
        )
    ));
    ?>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <td width="30%">
                <?php
                echo $this->Form->input('email', ['label' => ['text' => 'Email', 'class' => 'col-4'], 'type' => 'text', 'size' => '20']);
                echo $this->Form->input('password', ['label' => ['text' => 'Senha', 'class' => 'col-4'], 'type' => 'password', 'size' => '20']);
                ?>
                <div class='row justify-content-center'>
                    <div class='col-auto'>
                        <?php
                        echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
                        ?>
                        <?php
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <br>
                    <?php
                    echo $this->Html->link('Esqueceu a senha?', '/users/cadastro/');
                    echo " | ";
                    echo $this->Html->link('Fazer cadastro', '/users/cadastro/');
                    ?>
            </td>

            <td style="vertical-align: inherit">
                Prezadas(os) usuárias(os),
                <br />
                <br />
                Para fazer inscrição para seleção de estágio, assim como também para solicitar o termo de compromisso, é necessário estar <?php echo $this->Html->link('cadastrado', '/users/cadastro/'); ?> como usuária(o) do sistema.
                <br />
                <br />
                As(os) estudantes cadastrados poderão, além de fazer inscrição para seleção de estágio, solicitar <?php echo $this->Html->link('termo de compromisso', '/inscricaos/termosolicita/'); ?>, formulário de <?php echo $this->Html->link('avaliação discente', '/alunos/avaliacaosolicita/'); ?> de parte do supervisor, atualizar a informação sobre seus dados pessoais, assim como também, atualizar informação sobre as instituições campos de estágio da ESS/UFRJ.
                <br />
                <br />
                Supervisores e professores também podem realizar cadastro, e contribuir para atualizar dados das instituições, assim como manter atualizada a informação sobre seus dados profissionais.
                <br />
                <br />
                <p>Agora também está disponível para <i>download</i> a <?= $this->Html->link("Folha de atividades!", '/alunos/folhadeatividades') ?> e a <?= $this->Html->link('Declaração de estágio', '/estagiarios/declaracaoestagio') ?> </p>
                <br />
                <br />
                <p style="text-align: right">Coordenação de Estágio & Extensão</p>
            </td>
        </tr>
    </table>
</div>
