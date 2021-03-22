<?php
// pr($estagiarios);
?>
<?= $this->element('submenu_folhadeatividades') ?>
<?php
echo $this->Form->create('Folhadeatividade', [
    'class' => 'form-horizontal',
    'role' => 'form',
    'inputDefaults' => [
        'format' => ['before', 'label', 'between', 'input', 'error', 'after'],
        'div' => ['class' => 'form-group row'],
        'label' => ['class' => 'col-3'],
        'between' => '<div class = col-9>',
        'class' => ['form-control'],
        'after' => '</div>',
        'error' => false
    ]
]);
?>

<fieldset>
    <legend><?php echo __('Editar folha de atividades'); ?></legend>
    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('estagiario_id', ['type' => 'hidden']);
    echo $this->Form->input('nome', ['type' => 'text', 'label' => ['text' => 'Estagiário', 'class' => 'col-3'], 'value' => $estagiarios['Estagiario']['Aluno']['nome'], 'readonly']);
    echo $this->Form->input('dia', ['type' => 'date', 'dateFormat' => 'DMY', 'monthNames' => $meses, 'div' => 'form-group row', 'label' => ['text' => 'Dia', 'class' => 'col-3'], 'between' => "<div class = 'form-inline col-8'>", 'after' => '</div>']);
    echo $this->Form->input('inicio', ['type' => 'time', 'div' => 'form-group row', 'label' => ['text' => 'Início', 'class' => 'col-3'], 'div' => 'form-group row', 'between' => "<div class = 'form-inline col-8'>", 'after' => '</div>']);
    echo $this->Form->input('final', ['type' => 'time', 'div' => 'form-group row', 'label' => ['text' => 'Final', 'class' => 'col-3'], 'div' => 'form-group row', 'between' => "<div class = 'form-inline col-8'>", 'after' => '</div>']);
    echo $this->Form->input('atividade', ['type' => 'text', 'label' => ['text' => 'Atividade', 'class' => 'col-3']]);
    ?>
</fieldset>
<?php echo $this->Form->input('Confirmar', ['type' => 'submit', 'label' => false, 'class' => 'btn btn-primary']); ?>
<?php echo $this->Form->end(); ?>
