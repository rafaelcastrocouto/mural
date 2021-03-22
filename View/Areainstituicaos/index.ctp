<div class='table-responsive'>

    <?= $this->element('submenu_areainstituicoes') ?>

    <?php if ($this->Session->read('categoria') === 'administrador'): ?>
        <?php echo $this->Html->link('Inserir', '/areainstituicaos/add/'); ?>
        <br />
    <?php endif; ?>

    <h1>Áreas das instituições</h1>

    <div class='pagination justify-content-center'>
        <?= $this->Paginator->first('<< Primeiro ', array('class' => 'page-link')) ?>
        <?= $this->Paginator->prev('< Anterior ', array('class' => 'page-link'), null, array()) ?>
        <?= $this->Paginator->next(' Posterior > ', array('class' => 'page-link'), null, array()) ?>
        <?= $this->Paginator->last(' Último >> ', array('class' => 'page-link')) ?>
    </div>

    <div class="pagination justify-content-center">
        <?= $this->Paginator->numbers(array('separator' => false, 'class' => 'page-link')) ?>
    </div>

    <table class='table table-hover table-striped table-reponsive'>
        <thead>
            <tr>
                <th>
                    Id
                </th>
                <th>
                    Área
                </th>
                <th>
                    Quantidade de instituições
                </th>
            </tr>
        </thead>
        <?php foreach ($areas as $c_area): ?>

            <tr>
                <td>
                    <?php echo $this->Html->link($c_area['Areainstituicao']['id'], '/areainstituicaos/view/' . $c_area['Areainstituicao']['id']); ?>
                </td>

                <td>
                    <?php echo $this->Html->link($c_area['Areainstituicao']['area'], '/areainstituicaos/view/' . $c_area['Areainstituicao']['id']); ?>
                </td>

                <td>
                    <?php echo $c_area['Areainstituicao']['quantidadeArea']; ?>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>
</div>