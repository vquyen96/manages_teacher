$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('.table').DataTable({
        columnDefs: [
            { 'targets': [4], 'searchable': false, 'orderable': false, 'visible': true },
        ],
        order: []
    });
});