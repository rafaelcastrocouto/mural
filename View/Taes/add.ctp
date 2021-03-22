<?= $this->element('submenu_taes') ?>

<?php echo $this->Form->create('Tae'); ?>
<fieldset>
    <legend><?php echo __('Inserir'); ?></legend>
    <?php
    echo $this->Form->input('siape', ['class' => 'form-control']);
    echo $this->Form->input('nome', ['class' => 'form-control']);
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


