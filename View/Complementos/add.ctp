<?php echo $this->element('submenu_complementos'); ?>

<?php echo $this->Form->create('Complemento'); ?>
<fieldset>
    <legend><?php echo __('Inserir'); ?></legend>
    <?php
    echo $this->Form->input('periodo_especial', ['label' => 'Modalidade para período especial', 'class' => 'form-control']);
    ?>
</fieldset>
<div class='row justify-content-between'>
    <div class='col-auto'>
        <?php echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4 col-form-label'], 'class' => 'btn btn-primary']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
