<div class='container'>

    <?php echo $this->element('submenu_instituicoes'); ?>
    <?php if (isset($instituicoes)): ?>

        <h1>Resultado da busca de instituições</h1>

        <div class='row justify-content-center'>
            <?php $this->Paginator->options(array('url' => array($busca))); ?>

            <?php echo $this->Paginator->prev('<< Anterior ', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->next(' Posterior >> ', null, null, array('class' => 'disabled')); ?>
        </div>
        <div class='row justify-content-center'>
            <?php echo $this->Paginator->numbers(); ?>
        </div>
        <table class="table table-hover table-striped table-responsive">
            <?php foreach ($instituicoes as $c_instituicao): ?>
                <tr>
                    <td style='text-align:left'><?php echo $this->Html->link($c_instituicao['Instituicao']['instituicao'], '/Instituicaos/view/' . $c_instituicao['Instituicao']['id']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php else: ?>

    <div class='container'>
        <h1>Busca instituições</h1>

        <?php echo $this->Form->create('Instituicao', ['class' => 'form-inline']); ?>
        <?php echo $this->Form->input('instituicao', ['label' => ['text' => 'Instituição', 'style' => 'display:inline;'], ['class' => 'form-control']]); ?>
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

    <?php endif; ?>
</div>