<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <h1>Editar inscrição para seleção de estágio</h1>
    <br>
    <?php
    echo $this->Form->create('Inscricao');
    echo $this->Form->input('id_aluno', array('type' => 'hidden'));
    echo $this->Form->input('id_instituicao', array('type' => 'hidden'));
    echo $this->Form->input('Mural.instituicao', array('type' => 'hidden'));
    echo $this->Form->input('data', array('dateFormat' => 'DMY', 'type' => 'hidden'));
    echo $this->Form->input('periodo', array('type' => 'hidden'));
    ?>
    <div class='row justify-content-left'>
        <div class='col-auto'>
            <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>