$(function () {
    $('.js-basic-example').DataTable();

    //Exportable table
    $('.js-exportable').DataTable({
       
        dom: 'lBfrtip',
        responsive: true,        
        buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print'
        ]

    });
});