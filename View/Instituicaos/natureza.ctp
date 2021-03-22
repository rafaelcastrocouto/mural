<div class='table-responsive'>
    <?php echo $this->element('submenu_instituicoes'); ?>
    <?php ?>
    <table class='table table-hover table-striped table-responsive'>
        <caption style="caption-side: top">Natureza das instituições</caption>
        <thead class='thead-light'>
            <tr>
                <th>Natureza</th>
                <th>Quantidade de instituições</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < sizeof($natureza); $i++): ?>
                <tr>
                    <td><?= $this->Html->link($natureza[$i]['Instituicao']['natureza'], '/instituicaos/lista/natureza:' . $natureza[$i]['Instituicao']['natureza'] . '/linhas:0') ?></td>
                    <td><?= $natureza[$i]['0']['qnatureza'] ?></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>
