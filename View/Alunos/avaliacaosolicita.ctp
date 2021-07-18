<?=

$this->Html->script("jquery.maskedinput"); ?>

<script>

    $(document).ready(function () {

        $("#AlunoRegistro").mask("999999999");

    });

</script>

<?= $this->element('submenu_alunos'); ?>

    <h1>Formulário de avaliação discente</h1>
    <br />
    <p>No processo de solicitação do formulário de avaliação discente será solicitado verificar e, se for necessário, completar, a informação sobre o supervisor de campo. Os dados solicitaçãos são: Nome, Cress, telefone ou celular e e-mail. Todos os campos são obrigatórios.</p>
    <br />
    <p>Caso deseje mudar a instituição cadastrada como campo de estágio deve fazer uma nova solicitação de <?php echo $this->Html->link('termo de compromisso', '/inscricaos/termosoliciata/'); ?>, selecionando a instituição e o supervisor. Feito isso, pode solicitar o formulário de avalição discente.</p>
    <br />

<?php
echo $this->Form->create('Aluno', ['class' => 'form-inline']);
if ($this->Session->read('id_categoria') != '2') {
    echo $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row','label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'placeholder' => 'Digite o DRE', 'between' => '<div class ="form-inline col-8">', 'after' => '</div>','class' => 'form-control required']);
} else {
    echo $this->Form->input('registro', ['type' => 'text', 'div' => 'form-group row','label' => ['text' => 'DRE', 'class' => 'label-control col-1'], 'value' => $this->Session->read('numero'), 'readonly' ,'between' => '<div class ="form-inline col-8">', 'after' => '</div>','class' => 'form-control required']);
}
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
