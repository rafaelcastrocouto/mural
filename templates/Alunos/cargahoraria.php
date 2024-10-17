<?php
/**
 * @var \App\View\AppView $this
 */

//pr($carga_horaria_total); 
?>
<div class="alunos cargahoraria content">
    <div class='table_wrap'>
        <table>
            <thead>
                <tr>
                    <th>Id</th> 
                    <th><?= $this->Html->link("Registro", ['controller' => 'Alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'registro']]); ?></th>
                    <th><?= $this->Html->link("Semestres",['controller' => 'Alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'q_semestres']]); ?></th>
                    <th>Nível</th>
                    <th>Período</th>
                    <th>CH 1</th>
                    <th>Nível</th>
                    <th>Período</th>
                    <th>CH 2</th>
                    <th>Nível</th>
                    <th>Período</th>
                    <th>CH 3</th>
                    <th>Nível</th>
                    <th>Período</th>
                    <th>CH 4</th>
                    <th><?php echo $this->Html->link("Total", ['controller' => 'Alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'ch_total']]); ?></th>
                </tr>
            </thead>
            <?php $i = 1; ?>
            <?php foreach ($carga_horaria_total as $c_carga_horaria_total): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $this->Html->link($c_carga_horaria_total['registro'], ['controller' => 'Alunos', 'action' => 'view', $c_carga_horaria_total['id'] ]); ?></td>
                    <td><?php echo $c_carga_horaria_total['q_semestres']; ?></td>
        
                    <?php foreach ($c_carga_horaria_total as $cada_carga_horaria_total): ?>
            
                        <?php // pr($cada_carga_horaria_total); ?>
                        <?php if (is_array($cada_carga_horaria_total)): ?>
                            <td><?php echo $cada_carga_horaria_total['nivel']; ?></td>
                            <td><?php echo $cada_carga_horaria_total['periodo']; ?></td>
                            <td><?php echo $cada_carga_horaria_total['ch']; ?></td>
                        <?php endif; ?>
            
                    <?php endforeach; ?>
        
                    <td><?php echo $c_carga_horaria_total['ch_total']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>