<?php ?>

<?php
if ($professor['Professor']['siape']) {
    $this->Html->link('Estagiários', '/Estagiarios/index?siape=' . $professor['Professor']['siape'] . '&' . 'periodo=0');
}
?>

<?php echo $this->element('submenu_professores'); ?>

<?php if ($this->Session->read('id_categoria') == '3'): ?>
    <?= $this->Html->link('Meus estudantes', '/estagiarios/index?siape=' . $this->Session->read('numero'), ['role' => 'button', 'class' => 'btn btn-info']) ?>
<?php endif; ?> 

<div class='row justify-content-left'>
    <div class='col-auto'>
        <table class="table table-hover table-striped table-responsive">

            <tr>
                <td>SIAPE</td>
                <td><?php echo $professor['Professor']['siape']; ?></td>
            </tr>

            <tr>
                <td width='25%'>Nome</td>
                <?php
                if ($professor['Professor']['siape']):
                    ?>
                    <td width='75%'>
                        <?= $this->Html->link($professor['Professor']['nome'], '/Estagiarios/index?siape=' . $professor['Professor']['siape'] . '&' . 'periodo=0') ?>
                    </td>    
                    <?php
                else:
                    ?>
                    <td width='75%'>
                        <?= $professor['Professor']['nome'] ?>
                    </td>    
                <?php
                endif;
                ?>
            </tr>

            <tr>
                <td>Telefone</td>
                <td><?php echo $professor['Professor']['telefone']; ?></td>
            </tr>

            <tr>
                <td>Celular</td>
                <td><?php echo $professor['Professor']['celular']; ?></td>
            </tr>

            <tr>
                <td>Email</td>
                <td><?php echo $professor['Professor']['email']; ?></td>
            </tr>
            <tr>
                <td>Currículo lattes</td>
                <td>
                    <?php
                    if ($professor['Professor']['curriculolattes']) {
                        echo $this->Html->link('Lattes', 'http://lattes.cnpq.br/' . $professor['Professor']['curriculolattes']);
                    } else {
                        echo "Sem dados";
                    }
                    ?>
                </td>
            </tr>
            <!--
            <tr>
                <td>Diretorio de Grupos de Pesquisa</td>
                <td>
            <?php
            if ($professor['Professor']['pesquisadordgp']) {
                echo $this->Html->link('Pesquisador', 'http://dgp.cnpq.br/buscaoperacional/detalhepesq.jsp?pesq=' . $professor['Professor']['pesquisadordgp']);
            } else {
                echo "Sem dados";
            }
            ?>
                </td>
            </tr>
    
            <tr>
                <td>Data de ingresso na ESS/UFRJ</td>
                <td>
            <?php
            if ($professor['Professor']['dataingresso']) {
                echo date('d-m-Y', strtotime($professor['Professor']['dataingresso']));
            } else {
                echo "S/d";
            }
            ?>
                </td>
            </tr>
    //-->
            <tr>
                <td>Departamento</td>
                <td><?php echo $professor['Professor']['departamento']; ?></td>
            </tr>
            <!--
                    <tr>
                        <td>Motivo de egresso</td>
                        <td><?php echo $professor['Professor']['motivoegresso']; ?></td>
                    </tr>
            //-->
            <tr>
                <td>Observações</td>
                <td><?php echo $professor['Professor']['observacoes']; ?></td>
            </tr>

        </table>
    </div>
</div>

<?php if ($this->Session->read('id_categoria') == '3'): ?>
    <?= $this->Html->link('Editar', '/professors/edit?siape=' . $this->Session->read('numero'), ['role' => 'button', 'class' => 'btn btn-info']) ?>
<?php endif; ?> 
