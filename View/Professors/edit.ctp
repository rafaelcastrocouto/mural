<?php
?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#ProfessorCpf").mask("999999999-99");
        $("#ProfessorTelefone").mask("9999.9999");
        $("#ProfessorCelular").mask("99999.9999");

    });

</script>

<div class='table-responsive'>

    <?= $this->element('submenu_professores') ?>

    <?php
    echo $this->Form->create('Professor', [
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => [
            'format' => ['before', 'label', 'between', 'input', 'error', 'after'],
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-4'],
            'between' => "<div class = 'col-8'>",
            'class' => ['form-control'],
            'after' => "</div>",
            'error' => false
        ]
    ]);

    echo $this->Form->input('id', ['type' => 'hidden']);
    echo $this->Form->input('siape');
    echo $this->Form->input('nome');
// echo $this->Form->input('cpf');
// echo $this->Form->input('datanascimento', array('dateFormat'=>'DMY', 'minYear'=>'1900', 'empty'=>TRUE));
// echo $this->Form->input('localnascimento');
// echo $this->Form->input('sexo', array('options'=>array('1'=>'Masculino', '2'=>'Feminino')));
    echo $this->Form->input('telefone');
    echo $this->Form->input('celular');
    echo $this->Form->input('email');
// echo $this->Form->input('homepage');
// echo $this->Form->input('redesocial');
    echo $this->Form->input('curriculolattes');
// echo $this->Form->input('atualizacaolattes', array('dateFormat'=>'DMY', 'minYear'=>'1990', 'empty'=>TRUE));
// echo $this->Form->input('curriculosigma');
    echo $this->Form->input('pesquisadordgp');
// echo $this->Form->input('formacaoprofissional');
// echo $this->Form->input('universidadedegraduacao');
// echo $this->Form->input('anoformacao');
// echo $this->Form->input('mestradoarea');
// echo $this->Form->input('mestradouniversidade');
// echo $this->Form->input('mestradoanoconclusao');
// echo $this->Form->input('doutoradoarea');
// echo $this->Form->input('doutoradouniversidade');
// echo $this->Form->input('doutoradoanoconclusao');
    echo $this->Form->input('dataingresso', array('label'=> ['text' =>'Data de ingresso', 'class' => 'col-4'], 'dateFormat'=>'DMY', 'monthNames' => $meses, 'minYear'=>'1960', 'empty'=>TRUE, 'between' => "<div class = 'form-inline col-8'>"));
// echo $this->Form->input('formaingresso');
// echo $this->Form->input('tipocargo', array('options'=>array('efetivo'=>'Efetivo', 'substituto'=>'Substituto')));
// echo $this->Form->input('categoria', array('options'=>array('sem dados'=>'Sem dados', 'auxiliar'=>'Auxiliar', 'assistente'=>'Assistente', 'adjunto'=>'Adjunto', 'associado'=>'Associado', 'titular'=>'Titular', 'outro'=>'Outro'), 'default'=>0));
// echo $this->Form->input('regimetrabalho', array('options'=>array('40DE'=>'40DE', '40'=>'40', '20'=>'20')));
    echo $this->Form->input('departamento', array('options' => array('Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política Social')));
// echo $this->Form->input('dataegresso', array('dateFormat'=>'DMY', 'minYear'=>'1900', 'empty'=>TRUE));
    echo $this->Form->input('motivoegresso');
    echo $this->Form->input('observacoes');
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
</div>