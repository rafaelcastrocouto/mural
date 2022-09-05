<?php
// pr($orfaos);
?>
<div class='table-responsive'>
    <?= $this->element('submenu_estagiarios') ?>
    <p>Alunos sem estágios</p>

    <?php if (!empty($orfaos)): ?>

        <div class='table-responsive'>
            <table class='table table-striped table-hover table-responsive'>

                <?php foreach ($orfaos as $c_orfaos): ?>

                    <tr>

                        <td>
                            <?php echo $c_orfaos['id']; ?>
                        </td>

                        <td>
                            <?php echo $this->Html->link($c_orfaos['registro'], '/alunonovos/view?registro=' . $c_orfaos['registro']); ?>
                        </td>

                        <td>
                            <?php echo $this->Html->link($c_orfaos['nome'], '/alunos/view/' . $c_orfaos['id']); ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['celular']; ?>
                        </td>

                        <td>
                            <?php echo $c_orfaos['email']; ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>
        </div>

    <?php else: ?>
    <div class="alert alert-success" role="alert">
        <p>Não há erros no cadastramento de estudantes em estágio!</p>
    </div>
    <?php endif; ?>

</div>