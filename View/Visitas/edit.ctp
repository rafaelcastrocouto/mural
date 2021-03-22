<?php // pr($this->data['Visita']['data']);  ?>
<h1><?php echo $this->data['Instituicao']['instituicao']; ?></h1>

<?php

echo $this->Form->create('Visita', [
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

echo $this->Form->input('id', array('type' => 'hidden', 'class' => 'form-control'));
echo $this->Form->input('data', array('dateFormat'=>'DMY', 'empty'=>FALSE, 'class' => 'form-control'));
echo $this->Form->input('motivo', ['class' => 'form-control']);
echo $this->Form->input('responsavel', ['class' => 'form-control']);
echo $this->Form->input('descricao', ['class' => 'form-control']);
echo $this->Form->input('avaliacao', ['class' => 'form-control']);
echo $this->Form->end('Confirma');
?>