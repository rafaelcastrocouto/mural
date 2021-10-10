<?php

// pr($meses);      ?>

<?php echo $this->element('submenu_professores'); ?>

<script>
    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Professors', 'action' => 'index')); ?>";
        /* alert(base_url); */

        $("#ProfessorDepartamento").change(function () {
            var departamento = $(this).val();
            /* alert(departamento); */
            window.location = base_url + "/index?departamento=" + departamento;
        })
    });

</script>

<?php echo $this->Form->create('Professor', array('url' => 'index', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
<?php echo $this->Form->input('departamento', array('type' => 'select', 'options' => ['0' => 'Departamentos','Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Políticas'], 'default' => ['0'] ,'empty' => ['0' => 'Seleciona'], 'style' => 'width: 10em', 'class' => 'form-control form-control-sm')); ?>
<?php // echo $this->Form->end(); ?>

<div class='pagination justify-content-center'>
    <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
    <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
    <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
</div>

<div class="pagination justify-content-center">
    <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
</div>

<div class="pagination justify-content-center">
    <div class="col-auto">
        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <th>
                            <?php echo $this->Paginator->sort('Professor.siape', 'Siape'); ?>
                    </th>
                    <?php endif; ?>
                    <th>
                        <?php echo $this->Paginator->sort('Professor.nome', 'Nome'); ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort('Professor.email', 'Email'); ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort('Professor.curriculolattes', 'Lattes'); ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort('Professor.departamento', 'Departamento'); ?>
                    </th>
                    <th>
                        <?php echo $this->Paginator->sort('Professor.tipocargo', 'Tipo'); ?>
                    </th>

                    <?php if (($this->Session->read('categoria') === 'administrador') || ($this->Session->read('categoria')) === 'professor'): ?>
                    <th>
                            <?php echo $this->Paginator->sort('Professor.celular', 'Celular'); ?>
                    </th>
                    <th>
                            <?php echo $this->Paginator->sort('Professor.dataegresso', 'Egresso'); ?>
                    </th>
                    <th>
                            <?php echo $this->Paginator->sort('Professor.motivoegresso', 'Motivo'); ?>
                    </th>
                    <?php endif; ?>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($professores as $c_professor): ?>
                <tr>
                        <?php if ($this->Session->read('id_categoria') == '1'): ?>
                    <td>
                                <?php echo $c_professor['Professor']['siape']; ?>
                    </td>
                        <?php endif; ?>
                    <td>
                            <?php if (($this->Session->read('id_categoria') === 1) || ($this->Session->read('id_categoria') === 3)): ?>
                                <?php echo $this->Html->link($c_professor['Professor']['nome'], '/Professors/view/' . $c_professor['Professor']['id']); ?>
                            <?php else: ?>
                                <?php echo $c_professor['Professor']['nome']; ?>
                            <?php endif; ?>
                    </td>
                    <td>
                            <?php echo $c_professor['Professor']['email']; ?>
                    </td>
                    <td>
                            <?php
                            if ($c_professor['Professor']['curriculolattes']) {
                                echo $this->Html->link('Lattes', 'http://lattes.cnpq.br/' . $c_professor['Professor']['curriculolattes']);
                            } else {
                                echo "Sem lattes";
                            }
                            ?>
                    </td>
                    <td>
                            <?php echo $c_professor['Professor']['departamento']; ?>
                    </td>
                    <td>
                            <?php echo $c_professor['Professor']['tipocargo']; ?>
                    </td>

                        <?php if (($this->Session->read('categoria') === 'administrador') || ($this->Session->read('categoria')) === 'professor'): ?>
                    <td>
                                <?php echo $c_professor['Professor']['celular']; ?>
                    </td>
                    <td>
                                <?php
                                if ($c_professor['Professor']['dataegresso']):
                                echo date('d-m-Y', strtotime($c_professor['Professor']['dataegresso']));
                                endif;
                                ?>
                    </td>
                    <td>
                                <?php
                                if ($c_professor['Professor']['motivoegresso']):
                                echo date('d-m-Y', strtotime($c_professor['Professor']['motivoegresso'])); 
                                endif;
                                ?>
                    </td>
                        <?php endif; ?>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
echo $this->Paginator->counter(array(
    'format' => 'Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%'
));
?>
