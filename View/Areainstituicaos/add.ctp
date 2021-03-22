<?= $this->element('submenu_areainstituicoes') ?>

<?php

echo $this->Form->Create('Areainstituicao');
echo $this->Form->Input('area', ['class' => 'form-control']);
echo $this->Form->Submit('Confirma', ['class' => ['btn btn-primary']]);
echo $this->Form->End();

?>
