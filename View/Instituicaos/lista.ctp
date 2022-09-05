<?php
// pr($instituicoes);
// pr($q_paginas);
// pr($paginas[4]);
// pr($direcao);
// pr($ordem);
// pr($pagina);
// die();
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Instituicaos', 'action' => 'lista')); ?>";
        /* alert(base_url); */

        $("#InstituicaoLinhas").change(function () {
            var linhas = $(this).val();
            /* alert(linhas); */
            window.location = base_url + "/linhas:" + linhas;
        })

    })

</script>

<div class='table-responsive'>

    <?php echo $this->element('submenu_instituicoes'); ?>

    <?php if ($this->Session->read('id_categoria') == '1'): ?>

        <?php echo $this->Form->create('Instituicao', ['controller' => 'Instituicao', 'url' => 'lista', 'class' => 'form-inline']); ?>
        <?php echo $this->Form->input('linhas', ['type' => 'select', 'label' => ['text' => 'Linhas por páginas ', 'style' => 'display: inline'], 'options' => ['15' => '15', '0' => 'Todos'], 'selected' => $linhas, 'empty' => ['15' => 'Selecione'], 'class' => 'form-control']); ?>
        <?php echo $this->Form->end(); ?>

    <?php endif; ?>

    <br>

    <div class="row justify-content-center">
        <?php
// Menu superior de Navegação //
        if ($linhas != 0):

            echo $this->Html->link('<< Início ', 'lista/ordem:' . $ordem . '/pagina:' . 1 . '/direcao:' . $direcao, ['class' => 'page-link']);

            $retrocederpagina = $pagina - 1;
            echo $this->Html->link('<- Retroceder |', 'lista/ordem:' . $ordem . '/pagina:' . $retrocederpagina . '/direcao:' . $direcao, ['class' => 'page-link']);

            $avancarpagina = $pagina + 1;
            if ($avancarpagina > $q_paginas) {
                $avancarpagina = 0;
            }
            
            echo $this->Html->link('| Avançar -> ', 'lista/ordem:' . $ordem . '/pagina:' . $avancarpagina . '/direcao:' . $direcao, ['class' => 'page-link']);

            echo $this->Html->link('Última >> ', 'lista/ordem:' . $ordem . '/pagina:' . $q_paginas . '/direcao:' . $direcao, ['class' => 'page-link']);
            ?>
        </div>
        <?php
        $i = 1;
        $j = 1;
        // echo $j . "<br>";
        ?>
        <div class="row justify-content-center">
            <?php
            for ($k = 0; $k < 10; $k++):
                echo "&nbsp" . $this->Html->link(($pagina + $k), 'lista/ordem:' . $ordem . '/pagina:' . ($pagina + $k) . '/direcao:' . $direcao, ['class' => 'page-link']);
                if (($pagina + $k) >= $q_paginas) {
                    break;
                }
            endfor;
            ?>
        </div>        
        <?php
    endif;
    ?>

    <div class='table-responsive'>
        <table class='table table-hover table-striped table-responsive'>
            <thead class='thead-light'>
                <tr>
                    <th>
                        <?php echo $this->Html->link('Id', 'lista/ordem:instituicao_id/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>
                    <th>
                        <?php echo $this->Html->link('Instituicao', 'lista/ordem:instituicao/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>
                    <th>
                        <?php echo $this->Html->link('Expira', 'lista/ordem:expira/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>
                    <th>
                        <?php echo $this->Html->link('Visita', 'lista/ordem:visita/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>
                    <th>
                        <?php echo $this->Html->link('Último estágio', 'lista/ordem:ultimoperiodo/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>
                    <th>
                        <?php echo $this->Html->link('Estagiários', 'lista/ordem:estagiarios/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>
                    <th>
                        <?php echo $this->html->link('Supervisores', 'lista/ordem:supervisores/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>
                    <th>
                        <?php echo $this->html->link('Áreas', 'lista/ordem:area/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>
                    <th>
                        <?php echo $this->html->link('Natureza', 'lista/ordem:natureza/mudadirecao:' . $direcao . '/ṕagina:' . $pagina . '/linhas:' . $linhas); ?>
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($instituicoes as $c_instituicao): ?>
                    <?php // pr($c_instituicao);  ?>
                    <tr>
                        <td><?php echo $this->Html->link($c_instituicao['instituicao_id'], '/Instituicaos/view/' . $c_instituicao['instituicao_id']); ?></td>
                        <td><?php echo $this->Html->link($c_instituicao['instituicao'], '/Instituicaos/view/' . $c_instituicao['instituicao_id']); ?></td>
                        <td>
                            <?php
                            if ($c_instituicao['expira']):
                                echo date('d-m-Y', strtotime($c_instituicao['expira']));
                            endif;
                            ?>
                        </td>
                        <td><?php
                            if ($c_instituicao['visita']):
                                echo $this->Html->link(date('d-m-Y', strtotime($c_instituicao['visita'])), '/visitas/view/' . $c_instituicao['visita_id']);
                            endif;
                            ?>
                        </td>
                        <td><?php echo $this->Html->link($c_instituicao['ultimoperiodo'], '/estagiarios/index/id_instituicao:' . $c_instituicao['instituicao_id']); ?></td>
                        <td><?php echo $c_instituicao['estagiarios']; ?></td>
                        <td><?php echo $c_instituicao['supervisores']; ?></td>
                        <td><?php echo $c_instituicao['area']; ?></td>
                        <td><?php echo $c_instituicao['natureza']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>