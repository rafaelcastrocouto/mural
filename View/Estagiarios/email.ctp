<?php
// echo " Período atual: ";
// pr($email);
// echo " período: ";
// pr($periodo);
// pr($periodos);
// die();
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->url(array('controller' => 'Estagiarios', 'action' => 'email')); ?>";
        /* alert(base_url); */

        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "/periodo:" + periodo;
        })

    });

</script>

<?= $this->element('submenu_estagiarios') ?>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <?php echo $this->Form->create('Estagiario', [
            'url' => 'email',
            'class' => 'form-horizontal was-validated',
            'role' => 'form',
            'inputDefaults' => [
                'format' => ['before', 'label', 'between', 'input', 'after', 'error'],
                'div' => ['class' => 'form-group row'],
                'label' => ['class' => 'col-5'],
                'between' => "<div class = 'col-7'>",
                'class' => ['form-control'],
                'after' => '</div>',
                'error' => '<div class="invalid-feedback">Digite um valor correto neste campo.</div>'
            ]
        ]);

        echo $this->Form->input('periodo', array('type' => 'select', 'options' => $periodos, 'selected' => $periodo, 'empty' => array('0' => 'Período'), 'class' => 'form-control form-control-sm'));
        echo $this->Form->end();
        ?>
    </div>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>

        <?php ($periodo == '0' ? $periodo = "Todos" : $periodo = $periodo); ?>
        <h5>E-mails estagiarios período:
            <?php echo $periodo; ?>
        </h5>

        <div class='pagination justify-content-center'>
            <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
            <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
            <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
        </div>

        <div class="pagination justify-content-center">
            <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
        </div>
    </div>
</div>

<div class='row justify-content-center'>
    <div class='col-auto'>
        <table class="table table-hover table-striped table-responsive">
            <thead class='thead-light'>
                <tr style="height: 1px;">
                    <?php if ($this->Session->read('id_categoria') != '2'): ?>
                        <th rowspan="2" style="vertical-align: middle;">
                            <?php echo $this->Paginator->sort('Alunonovo.nome', 'Nome'); ?>
                        </th>
                    <?php endif; ?>
                </tr>
            </thead>
            <?php $estagiarios = null ?>
            <?php foreach ($email as $aluno): ?>
                <?php # pr($aluno) ?>
                <?php if ($aluno['Alunonovo']['email']): ?>
                    <tr>
                        <td class='text-left'>
                            <?php echo $this->Html->link('"' . $aluno['Alunonovo']['nome'] . '"' . ' <' . $aluno['Alunonovo']['email'] . '>' . ', ', ['controller' => 'Alunonovos', 'action' => 'view', $aluno['Alunonovo']['id']]); ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr class='bg-warning text-dark'>
                        <?php if ($aluno['Alunonovo']['nome']): ?>
                            <td class='text-left'>
                                <?php echo $this->Html->link('"' . $aluno['Alunonovo']['nome'] . '"' . ' <' . "estagio@ess.ufrj.br" . '>' . ', ', ['controller' => 'Alunonovos', 'action' => 'view', $aluno['Alunonovo']['id']]); ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
                <?php $estagiarios .= '"' . $aluno['Alunonovo']['nome'] . '" ' . htmlspecialchars('<') . $aluno['Alunonovo']['email'] . htmlspecialchars('>') . ', ' . '<br>'; ?>
            <?php endforeach; ?>
        </table>
        <?php // print_r($estagiarios) ?>
        <?php
        echo $this->Paginator->counter(
            array(
                'format' => "Página %page% de %pages%,
exibindo %current% registros do %count% total,
começando no registro %start%, finalizando no %end%"
            )
        );
        ?>
    </div>
</div>