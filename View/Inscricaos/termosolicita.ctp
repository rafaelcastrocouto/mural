<?= $this->Html->script("jquery.maskedinput"); ?>

<script>
    $(document).ready(function () {

        $("#InscricaoIdAluno").mask("999999999");

    });

</script>

<?= $this->element('submenu_inscricoes') ?>

<h1>Termo de compromisso</h1>

<?php
echo $this->Form->create('Inscricao', ['class' => 'form-inline']);
if ($this->Session->read('id_categoria') != '2'):
    echo $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row', 'label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'placeholder' => 'Digite o DRE', 'required', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
else:
    echo $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row', 'label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'value' => $this->Session->read('numero'), 'readonly', 'required', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
endif;
?>
<div class='row justify-content-between'>
    <div class='col-auto'>
        <?php
        echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
        ?>
        <?php
        echo $this->Form->end();
        ?>
    </div>
</div>
