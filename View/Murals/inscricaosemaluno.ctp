<?php
// pr($alunosnaocadastrados);
// die();
?>

<div class='table-responsive'>

    <?php
    /* Mostra um menú superior para o estudante diferente segundo seja estagiario ou nao */
    // pr($this->Session->read('id_categoria'));
    if ($this->Session->read('id_categoria') == '2'):
        if ($this->Session->read('numero') !== null):
            // pr($this->Session->read('numero'));
            $estagiario = $this->Session->read('estagiario');
            if (isset($estagiario) && ($estagiario == '1')):
                $this->element('submenu_nav_estudante');
            elseif (isset($estagiario) && ($estagiario == '0')):
                $this->element('submenu_nav_aluno');
            endif;
        endif;
    elseif ($this->Session->read('id_categoria') == '1'):
        echo $this->element("submenu_mural");
    endif;
    ?>

    <div class="row justify-content-center">
        <div class="col-auto">

            <h1 style="text-align: center;">Estudantes que realizaram inscrições sem cadastro</h1>
        </div>
    </div>

    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Inscrição</th>
                <th>Registro</th>
                <th>Período</th>
                <th>Estagiário</th>
                <th>Período</th>
                <th>Nível</th>
                <th>Estudante</th>
                <th>Registro</th>
                <th>Aluno</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunosnaocadastrados as $c_alunosnaocadastrados): ?>
                <?php foreach ($c_alunosnaocadastrados as $data): ?>
                    <?php // pr($data) ?>
                    <?php // die(); ?>
                    <tr>
                        <?php if ($this->Session->read('id_categoria') == '1'): ?>
                            <td><?php echo $this->Html->link($data['Inscricao']['id'], '/Inscricaos/view/' . $data['Inscricao']['id']); ?></td>
                        <?php endif; ?>
                        <td style="text-align: center"><?php echo $data['Inscricao']['id_aluno']; ?></td>
                        <td style="text-align: center"><?php echo $data['Inscricao']['periodo']; ?></td>
                        <td style="text-align: center"><?php echo isset($data['Estagiario']['Instituicao']['instituicao']) ? $this->Html->link($data['Estagiario']['Instituicao']['instituicao'], '/Estagiarios/view/' . $data['Estagiario']['id']) : NULL; ?></td>
                        <td style="text-align: center"><?php echo $data['Estagiario']['periodo']; ?></td>
                        <td style="text-align: center"><?php echo $data['Estagiario']['nivel']; ?></td>
                        <td style="text-align: center"><?php echo isset($data['Estagiario']['Alunonovo']['nome']) ? $this->Html->link($data['Estagiario']['Alunonovo']['nome'], '/Alunonovos/view/' . $data['Estagiario']['Alunonovo']['id']) : NULL; ?></td>
                        <td style="text-align: center"><?php echo isset($data['Estagiario']['Aluno']['nome']) ? $this->Html->link($data['Estagiario']['Aluno']['registro'], '/Alunos/view/' . $data['Estagiario']['Aluno']['id']) : NULL; ?></td>
                        <td style="text-align: center"><?php echo isset($data['Estagiario']['Aluno']['nome']) ? $this->Html->link($data['Estagiario']['Aluno']['nome'], '/Alunos/view/' . $data['Estagiario']['Aluno']['id']) : NULL; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
