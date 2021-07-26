<?php ?>
<div class="table-responsive">

<?= $this->element('submenu_extensaos'); ?>

    <?php
    echo $this->Form->create('Extensao', array(
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
    <fieldset>
        <legend><?php echo __('Editar'); ?></legend>
<?php
echo $this->Form->input('id');
echo $this->Form->input('titulo', ['rows' => 2]);
echo $this->Form->input('docente_id', ['label' => ['text' => 'Coordenador[a] docente', 'class' => 'col-4'], 'empty' => TRUE]);
echo $this->Form->input('tae_id', ['label' => ['text' => 'Coordenador[a] técnico', 'class' => 'col-4'], 'empty' => TRUE]);
echo $this->Form->input('datacongregacao', ['label' => ['text' => 'Aprovado em congregação', 'class' => 'col-4'], 'empty' => TRUE, 'between' => "<div class = 'form-inline col-8'>"]);
echo $this->Form->input('versao', ['label' => ['text' => 'Versão', 'class' => 'col-4'], 'empty' => TRUE]);
echo $this->Form->input('situacaopr5_id', ['label' => ['text' => 'Situação', 'class' => 'col-4'], 'options' => $situacaopr5, 'empty' => TRUE]);
echo $this->Form->input('observacoes', ['label' => ['text' => 'Observações', 'class' => 'col-4'], 'rows' => 2]);
        ?>
    </fieldset>
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
