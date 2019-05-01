$(function () {
    $('#example1').DataTable({
        columnDefs: [
            { 'targets': [4], 'searchable': false, 'orderable': false, 'visible': true },
        ],
        order: []
    });
})