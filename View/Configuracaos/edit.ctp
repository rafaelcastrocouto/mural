<style>
    fieldset {
        border: 3px solid #999;
        padding: 10px;
        /* controla a distancia entre os elementos e a borda */
        margin: 15px;
        width: 100%;
        /* margem para alinhar o fieldset com o restante do grid */
    }
</style>

<?php echo $this->Form->create('Configuracao', ['class' => 'form-horizontal']); ?>

<fieldset>
    <legend class='w-auto'>Mural</legend>
    <?php
    echo $this->Form->input('mural_periodo_atual', ['div' => 'form-group row', 'label' => ['text' => 'Período atual do mural', 'class' => 'col-form-label col-4'], 'between' => '<div class = "form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
    echo $this->Form->input('periodo_calendario_academico', ['div' => 'form-group row', 'label' => ['text' => 'Período atual do calendário acadêmico', 'class' => 'col-form-label col-4'], 'between' => '<div class = "form-inline col-8">', 'after' => '<small>Para fazer a declaração de periódo que o aluno está cursando</small></div>', 'class' => 'form-control']);
    echo $this->Form->input('termo_compromisso_periodo', ['div' => 'form-group row', 'label' => ['text' => 'Período atual do termo de compromisso', 'class' => 'col-form-label col-4'], 'between' => '<div class = "form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
    echo $this->Form->input('termo_compromisso_inicio', array('type' => 'date', 'div' => 'form-group row', 'label' => ['text' => 'Data de inicio do termo de compromisso', 'class' => 'col-form-label col-4'], 'dateFormat' => 'DMY', 'monthNames' => $meses, 'between' => '<div class = "form-inline col-8">', 'after' => '</div>', 'class' => 'form-control'));
    echo $this->Form->input('termo_compromisso_final', array('type' => 'date', 'div' => 'form-group row', 'label' => ['text' => 'Data de finalização do termo de compromisso', 'class' => 'col-form-label col-4'], 'dateFormat' => 'DMY', 'monthNames' => $meses, 'between' => '<div class ="form-inline col-8">', 'after' => '</div>', 'class' => 'form-control'));
    ?>
</fieldset>
<br>
<fieldset>
    <legend class='w-auto'>Curso de supervisores</legend>
    <?php
    echo $this->Form->input('curso_turma_atual', ['div' => 'form-group row', 'label' => ['text' => 'Turma atual do curso', 'class' => 'col-form-label col-4'], 'between' => '<div class = "form-inline col-8">', 'after' => '</div>', 'class' => 'form-control']);
    echo $this->Form->input('curso_abertura_inscricoes', array('type' => 'date', 'div' => 'form-group row', 'label' => ['text' => 'Data de abertura das inscrições para o curso de supervisores', 'class' => 'col-form-label col-4'], 'dateFormat' => 'DMY', 'monthNames' => $meses, 'between' => '<div class = "form-inline col-8">', 'after' => '</div>', 'class' => 'form-control'));
    echo $this->Form->input('curso_encerramento_inscricoes', array('type' => 'date', 'div' => 'form-group row', 'label' => ['text' => 'Data de encerramento das inscrições para o curso de supervisores', 'class' => 'col-form-label col-4'], 'dateFormat' => 'DMY', 'monthNames' => $meses, 'between' => '<div class = "form-inline col-8">', 'after' => '</div>', 'class' => 'form-control'));
    ?>
</fieldset>    

<div class='row justify-content-leftr'>
    <div class='col-auto'>
        <?php
        echo $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
        ?>
        <?php
        echo $this->Form->end();
        ?>
    </div>
</div>
