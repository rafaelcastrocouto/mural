<?php
// pr($professores);
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

    <h1>Cadastro de professora(o)</h1>

    <?php
    echo $this->Form->create('Professor', [
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => [
            'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
            'div' => ['class' => 'form-group row'],
            'label' => ['class' => 'col-4'],
            'between' => "<div class = 'col-8'>",
            'class' => ['form-control'],
            'after' => "</div>",
            'error' => false
        ]
    ]);

    echo $this->Form->input('nome');
    echo $this->Form->input('siape');
// echo $this->Form->input('cpf');
// echo $this->Form->input('datanascimento', array('dateFormat'=>'DMY', 'empty'=>TRUE));
// echo $this->Form->input('localnascimento');
// echo $this->Form->input('sexo', array('options'=>array('1'=>'Masculino', '2'=>'Feminino')));
    echo $this->Form->input('telefone');
    echo $this->Form->input('celular');
    echo $this->Form->input('email');
// echo $this->Form->input('homepage');
// echo $this->Form->input('redesocial');
    echo $this->Form->input('curriculolattes', ['label' => ['text' => 'Lattes', 'class' => 'col-4'], 'placeholder' => 'Colocar somente o número posterior ao endereço http://lattes.cnpq.br/']);
// echo $this->Form->input('atualizacaolattes', array('dateFormat'=>'DMY', 'empty'=>TRUE));
// echo $this->Form->input('curriculosigma');
// echo $this->Form->input('pesquisadordgp');
// echo $this->Form->input('formacaoprofissional');
// echo $this->Form->input('universidadedegraduacao');
// echo $this->Form->input('anoformacao');
// echo $this->Form->input('mestradoarea');
// echo $this->Form->input('mestradouniversidade');
// echo $this->Form->input('mestradoanoconclusao');
// echo $this->Form->input('doutoradoarea');
// echo $this->Form->input('doutoradouniversidade');
// echo $this->Form->input('doutoradoanoconclusao');
// echo $this->Form->input('dataingresso', array('label'=> ['text' =>'Data de ingresso', 'class' => 'col-4'], 'dateFormat'=>'DMY', 'monthNames' => $meses, 'minYear'=>'1960', 'empty'=>TRUE, 'between' => "<div class = 'form-inline col-8'>"));
// echo $this->Form->input('formaingresso');
// echo $this->Form->input('tipocargo');
// echo $this->Form->input('categoria', array('label'=>'Categoria (Adjunto, etc.)'));
// echo $this->Form->input('regimetrabalho');
    echo $this->Form->input('departamento', array('options' => array('Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Politica social' => 'Política social')));
// echo $this->Form->input('dataegresso', array('dateFormat'=>'DMY', 'empty'=>TRUE));
// echo $this->Form->input('motivoegresso');
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