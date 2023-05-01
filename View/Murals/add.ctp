<?php ?>

<?= $this->Html->script("jquery.maskedinput"); ?>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/translations/pt.js"></script>

<style>
.ck-editor__editable_inline {
    min-height: 150px;
}
</style>

<script>

    $(document).ready(function () {

        $("#MuralCargaHoraria").mask("99");
        $("#MuralHorarioSelecao").mask("99:99");

        ClassicEditor
                .create(document.querySelector('#MuralRequisitos'), {
                    // The language code is defined in the https://en.wikipedia.org/wiki/ISO_639-1 standard.
                    language: 'pt'
                })
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
                
        ClassicEditor
                .create(document.querySelector('#MuralOutras'), {
                    language: 'pt'
                })
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
    });
</script>

<div class="container m-2">
    <div class='row justify-content-center'>

        <?= $this->element("submenu_mural") ?>

        <h1>Inserir solicitação de vagas para estágio</h1>

        <?php
        echo $this->Form->create('Mural', [
            'class' => 'form-horizontal',
            'role' => 'form',
            'inputDefaults' => [
                'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
                'div' => ['class' => 'form-group row'],
                'label' => ['class' => 'col-2'],
                'between' => '<div class = col-9>',
                'class' => ['form-control'],
                'after' => '</div>',
                'error' => ['attributes' => ['wrap' => 'span', 'class' => 'help-inline']]
            ]
        ]);
        ?>

        <?php echo $this->Form->input('periodo', array('type' => 'hidden', 'value' => $periodo)); ?>

        <?php echo $this->Form->input('id_estagio', array('label' => ['class' => 'col-2', 'text' => 'Instituição (se a instituição não está cadastrada, tem que cadastrar no menu Instituições)'], 'type' => 'select', 'options' => $instituicoes)); ?>

        <?php echo $this->Form->input('convenio', array('label' => ['class' => 'col-2', 'text' => 'Convênio com a UFRJ'], 'type' => 'select', 'options' => ['0' => 'Não', '1' => 'Sim'])); ?>

        <?php echo $this->Form->input('vagas', array('label' => ['class' => 'col-2', 'text' => 'Vagas (digitar somente números inteiros)'], 'default' => 0)); ?>

        <?php echo $this->Form->input('beneficios'); ?>

        <?php echo $this->Form->input('final_de_semana', array('label' => ['class' => 'col-2', 'text' => 'Estágio de final de semana'], 'type' => 'select', 'options' => array('0' => 'Não', '1' => 'Sim', '2' => 'Parcialmente'), 'selected' => 0)); ?>

        <?php echo $this->Form->input('cargaHoraria', ['type' => 'text']); ?>

        <?php echo $this->Form->input('requisitos', array('rows' => 4)); ?>

        <?php echo $this->Form->input('id_area', array('label' => ['class' => 'col-2', 'text' => 'Área de OTP'], 'type' => 'select', 'options' => $areas)); ?>

        <?php echo $this->Form->input('horario', array('label' => ['class' => 'col-2', 'text' => 'Horário da OTP'], 'type' => 'select', 'options' => array('D' => 'Diurno', 'N' => 'Noturno', 'A' => 'Ambos'))); ?>

        <?php echo $this->Form->input('id_professor', array('label' => ['class' => 'col-2', 'text' => 'Professor'], 'type' => 'select', 'options' => $professores)); ?>

        <?php echo $this->Form->input('dataSelecao', array('type' => 'date', 'label' => ['class' => 'col-2', 'text' => 'Data da seleção'], 'dateFormat' => 'DMY', 'monthNames' => $meses, 'minYear' => '2000', 'empty' => TRUE, 'between' => "<div class = 'form-inline col-8'>")); ?>

        <?php echo $this->Form->input('horarioSelecao'); ?>

        <?php echo $this->Form->input('localSelecao'); ?>

        <?php echo $this->Form->input('formaSelecao', array('label' => ['class' => 'col-2', 'text' => 'Forma de seleção'], 'type' => 'select', 'options' => array('0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outras'))); ?>

        <?php echo $this->Form->input('dataInscricao', array('label' => ['class' => 'col-2', 'text' => 'Data final da inscrição'], 'dateFormat' => 'DMY', 'monthNames' => $meses, 'minYear' => '2000', 'empty' => TRUE, 'between' => "<div class = 'form-inline col-8'>")); ?>

        <?php echo $this->Form->input('contato'); ?>

        <?php echo $this->Form->input('email', array('label' => ['class' => 'col-2', 'text' => 'Email para envio da lista de inscrições'])); ?>

        <?php echo $this->Form->input('datafax', array('label' => ['class' => 'col-2', 'text' => 'Data de envio do email (preenchimento automático)'], 'dateFormat' => 'DMY', 'monthNames' => $meses, 'empty' => TRUE, 'between' => "<div class = 'form-inline col-8'>")); ?>

        <?php echo $this->Form->input('localInscricao', array('label' => ['class' => 'col-2', 'text' => 'Inscrição'], 'type' => 'select', 'options' => array('0' => 'Mural da Coordenação de Estágio/ESS', '1' => 'Mural de Coordenação de Estágio e na Instituição'))); ?>

        <?php echo $this->Form->input('outras', array('label' => ['class' => 'col-2 ckeditor', 'text' => 'Outras informações'])); ?>

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
</div>
