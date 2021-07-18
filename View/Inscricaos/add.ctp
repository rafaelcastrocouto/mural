<?php ?>

<?= $this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#InscricaoIdAluno").mask("999999999");

    });

</script>

<div class='table-responsive'>

<?= $this->element('submenu_inscricoes') ?>

    <h1>Digite o número de DRE</h1>

    <?php
    
    echo $this->Form->create('Inscricao', array('url' => 'add/' . $id_instituicao));
    
    if ($this->Session->read('id_categoria') == "2") {
        echo $this->Form->input('id_aluno', array('type' => 'text', 'label' => 'Registro (DRE)', 'size' => 9, 'maxlenght' => 9, 'readonly', 'default' => $this->Session->read('numero'), 'class' => 'form-control'));
    } else {
        echo $this->Form->input('id_aluno', array('type' => 'text', 'label' => 'Registro (DRE)', 'size' => 9, 'maxlenght' => 9, 'dafault' => NULL, 'class' => 'form-control'));
    }
    echo $this->Form->input('id_instituicao', array('type' => 'hidden', 'value' => $id_instituicao));
    ?>
    <div class='row justify-content-between'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>