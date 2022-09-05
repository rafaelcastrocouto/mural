<?php ?>

<?= $this->Html->script("jquery.maskedinput") ?>

<script>

    $(document).ready(function () {

        $("#SupervisorTelefone").mask("9999.9999");
        $("#SupervisorCelular").mask("99999.9999");

    });

</script>

<div class='table-responsive'>

    <?= $this->element('submenu_alunos') ?>

    <table class='table table-hover table-striped table-responsive'>
        <tr>
            <td>Estudante:</td><td><?php echo $aluno; ?></td>
        </tr>
        <tr>
            <td>Registro:</td><td><?php echo $registro; ?></td>
        </tr>
        <tr>
            <td>Período:</td><td><?php echo $periodo; ?></td>
        </tr>
        <tr>
            <td>Nível:</td><td><?php echo $nivel; ?></td>
        </tr>
        <tr>
            <td>Professor(a):</td><td><?php echo $professor; ?></td>
        </tr>
        <tr>
            <td>Instituição:</td><td><?php echo $instituicao; ?></td>
        </tr>
        <?php
        if (!empty($supervisor)):
            ?>

            <tr>
                <td>Supervisor(a):</td><td><?php echo $supervisor; ?></td>
            </tr>
            <?php
        endif;
        ?>

        <?php
        if (empty($supervisor)):
            ?>
            <tr>
                <td colspan="2">
                    <?php
                    echo $this->Form->create('Estagiario', [
                        'class' => 'form-horizontal',
                        'role' => 'form',
                        'inputDefaults' => [
                            'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
                            'div' => ['class' => 'form-group'],
                            'label' => [false],
                            'between' => "<div class = 'col-12'>",
                            'class' => ['form-control'],
                            'after' => "</div>",
                            'error' => false
                        ]
                    ]);

                    echo $this->Form->input('supervisor_id', ['label' => false, 'type' => 'select', 'options' => $supervisores, 'empty' => 'Seleciona supervisor(a)']);
                    echo $this->Form->input('registro', ['type' => 'hidden', 'value' => $registro]);
                    echo $this->Form->input('estagiario_id', ['type' => 'hidden', 'value' => $estagiario_id]);
                    ?>

                    <div class='row justify-content-center'>
                        <div class='col-auto'>
                            <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
                            <?= $this->Form->end(); ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
        else:
            ?>
            <tr>
                <td>
                    <?php
                    echo $this->Form->create('Estagiario', [
                        'class' => 'form-horizontal',
                        'role' => 'form',
                        'inputDefaults' => [
                            'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
                            'div' => ['class' => 'form-group row'],
                            'label' => ['class' => 'col-4'],
                            'between' => "<div class = 'col-8'>",
                            'class' => ['form-control'],
                            'after' => "</div>",
                            'error' => false
                        ]
                    ]);

                    echo $this->Form->input('supervisor', ['type' => 'hidden', 'value' => $supervisor, 'readonly']);
                    echo $this->Form->input('supervisor_id', ['type' => 'hidden', 'value' => $supervisor_id]);
                    echo $this->Form->input('registro', ['type' => 'hidden', 'value' => $registro]);
                    echo $this->Form->input('estagiario_id', ['type' => 'hidden', 'value' => $estagiario_id]);
                    ?>

                    <div class='row justify-content-center'>
                        <div class='col-auto'>
                            <?= $this->Form->submit('Confirma', ['type' => 'Submit', 'label' => ['text' => 'Confirma', 'class' => 'col-4'], 'class' => 'btn btn-primary']); ?>
                            <?= $this->Form->end(); ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php
        endif;
        ?>
    </table>

</div>