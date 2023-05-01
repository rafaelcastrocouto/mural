<?php
// pr($estudantes);
// die();
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>

    var path = "<?= $this->Html->url(['controller' => 'inscricaos', 'action' => 'orfao']) ?>";
    const FROM_PATTERN = 'YYYY-MM-DD';
    const TO_PATTERN = 'DD/MM/YYYY';
    $(document).ready(function () {

        $('#orfaos').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            ordering: true,
            order: ['2', 'asc'],
            paging: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            language: {
                lengthMenu: 'Mostra _MENU_ registros por página',
                zeroRecords: 'Sem resultados',
                info: 'Mostrando _PAGE_ página de _PAGES_',
                infoEmpty: 'Nenhum registro disponível',
                infoFiltered: '- (filtrados de um total de _MAX_ registros)',
                search: 'Buscar:',
                paginate: {
                    first: 'Primeiro',
                    previous: 'Anterior',
                    next: 'Posterior',
                    last: 'Último',
                },
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= $this->Html->url(['controller' => 'inscricaos', 'action' => 'orfao']) ?>",
                dataSrc: 'data'
            },
            columns: [
                {data: 'id', name: 'Id'},
                {data: "registro", name: 'Registro'},
                {data: "nome", name: 'Nome'},
                {data: "celular", name: 'Celular'},
                {data: "email", name: 'E-mail'},
                {data: "inscricao", name: 'Inscrições'},
                {data: "estagios", name: 'Estágios'},
            ],
            bFilter: true, // to display datatable search
        });
    });

</script>
<div class='table-responsive'>
    <?= $this->element('submenu_inscricoes') ?>
    <h1 class='h2'>Estudantes por inscrições e estágio</h1>

    <table class='table table-hover table-striped table-responsive' id='orfaos'>

        <thead class='thead-light'>
            <tr>
                <?php if ($this->Session->read('id_categoria') === 1): ?>
                    <th>Id</th>
                    <th>DRE</th>
                    <th>Estudante</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>Inscrições</th>
                    <th>Estágios</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>