<?php echo $this->Html->link('Configurações', '/configuracaos/view/1', ['role' => 'button', 'class' => 'btn btn-info mr-1']); ?>
<?php echo $this->Html->link('Usuários', '/users/index/', ['role' => 'button', 'class' => 'btn btn-info mr-1']); ?>
<?php echo $this->Html->link('Planilha seguro', '/alunos/planilhaseguro/', ['role' => 'button', 'class' => 'btn btn-info mr-1']); ?>
<?php echo $this->Html->link('Planilha CRESS', '/alunos/planilhacress/', ['role' => 'button', 'class' => 'btn btn-info mr-1']); ?>
<?php echo $this->Html->link('Carga horária', '/alunos/cargahoraria/', ['role' => 'button', 'class' => 'btn btn-info mr-1']); ?>
<?php echo $this->Html->link('Modalidade', '/complementos/index/', ['role' => 'button', 'class' => 'btn btn-info']); ?>
<!--
<?php echo $this->Html->link('Planejamento', '/configuraplanejamentos/index/'); ?>
//-->

<h1>Configuração</h1>

<table class='table table-hover table-striped table-response'>

    <tr>
        <td>
            Período atual do mural
        </td>
        <td>
            <?php echo $configuracao['Configuracao']['mural_periodo_atual']; ?>
        </td>
    </tr>

    <tr>
        <td>
            Período do calendário acadêmico atual<br>
            <small>Para fazer a declaração de período que o aluno está cursando</small>
        </td>
        <td>
            <?php echo $configuracao['Configuracao']['periodo_calendario_academico']; ?>
        </td>
    </tr>

    <tr>
        <td>
            Período do termo de compromisso
        </td>
        <td>
            <?php echo $configuracao['Configuracao']['termo_compromisso_periodo']; ?>
        </td>
    </tr>

    <tr>
        <td>
            Data de início do termo de compromisso
        </td>
        <td>
            <?php echo date('d-m-Y', strtotime($configuracao['Configuracao']['termo_compromisso_inicio'])); ?>
        </td>
    </tr>

    <tr>
        <td>
            Data de finalização do termo de compromisso
        </td>
        <td>
            <?php echo date('d-m-Y', strtotime($configuracao['Configuracao']['termo_compromisso_final'])); ?>
        </td>
    </tr>

    <tr>
        <td>
            Turma atual do curso de supervisores
        </td>
        <td>
            <?php echo $configuracao['Configuracao']['curso_turma_atual']; ?>
        </td>
    </tr>

    <tr>
        <td>
            Data de abertura das inscrições para o curso de supervisores
        </td>
        <td>
            <?php echo date('d-m-Y', strtotime($configuracao['Configuracao']['curso_abertura_inscricoes'])); ?>
        </td>
    </tr>

    <tr>
        <td>
            Data de encerramento das inscrições para o curso de supervisores
        </td>
        <td>
            <?php echo date('d-m-Y', strtotime($configuracao['Configuracao']['curso_encerramento_inscricoes'])); ?>
        </td>
    </tr>

</table>

<?php
echo $this->Html->link('Editar', '/Configuracaos/edit/' . $configuracao['Configuracao']['id'], ['role' => 'button', 'class' => 'btn btn-info']);
?>
