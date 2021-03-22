<div class='table-responsive'>
    <?= $this->element('submenu_areas') ?>
    <?php
    echo $this->Form->Create('Area');
    echo $this->Form->Input('area', ['label' => 'Área', 'class' => 'form-control']);
    ?>
    <div class='row justify-content-left'>
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