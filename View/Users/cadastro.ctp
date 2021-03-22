<?php ?>

<script>

    $(document).ready(function () {
        $("#UserCategoria").change(function () {

            var categoria = $(this).val();

            if (categoria == 2) {
                $("label:eq(1)").text("DRE");
            } else if (categoria == 3) {
                $("label:eq(1)").text("SIAPE");
            } else if (categoria == 4) {
                $("label:eq(1)").text("CRESS 7ª Região");
            }

        })
    })

</script>

<div class='table-responsive'>
    <h1>Cadastro de usuário</h1>

    <?php echo $this->Form->create("User"); ?>

    <table class='table table-hover table-striped table-responsive'>

        <tr>
            <td>
                <?php echo $this->Form->input('categoria', array('options' => array('9' => '- Selecione -', '2' => 'Estudante', '3' => 'Professor', '4' => 'Supervisor'), 'default' => '9', 'class' => 'form-control')); ?>
            </td>
            <td>
                <?php echo $this->Form->input('numero', array('label' => 'Selecione a categoria de usuário no box anterior', 'class' => 'form-control')); ?>
            </td>
        </tr>

        <tr>
            <td colspan='2'>
                <?php echo $this->Form->input('email', ['class' => 'form-control']); ?>
            </td>
        </tr>

        <tr>
            <td colspan='2'>
                <?php echo $this->Form->input('password', array('label' => 'Senha', 'class' => 'form-control')); ?>
            </td>
        </tr>
        <!--
            <td colspan='2'>
        <?php echo $this->Form->input('Confirmar a senha', array('type' => 'password')); ?>
            </td>
        -->
        </tr>

    </table>
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