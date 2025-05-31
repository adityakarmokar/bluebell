$(document).ready(function() { 

	var userType = window.userType;	

	var tableConfig = {
        "processing": true,
        "responsive": true,
        "searching": true,
        "ordering": true,
        "paging": true,        
    };

	if (userType !== 'user') {
		tableConfig.dom = 'Bfrtip';
        tableConfig.buttons = [
            {
                extend: 'copyHtml5',
                text: 'Copy'
            },
            {
                extend: 'excelHtml5',
                text: 'Export to Excel'
            },
            {
                extend: 'csvHtml5',
                text: 'Export to CSV'
            },
            {
                extend: 'pdfHtml5',
                text: 'Export to PDF',
                orientation: 'portrait',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: 'Print'
            }
        ];
    }

    var table = $('#usersTable').DataTable(tableConfig);

	if (userType !== 'user') {
        $('.buttons-copy').addClass('btn btn-sm btn-primary');
        $('.buttons-csv').addClass('btn btn-sm btn-primary');
        $('.buttons-pdf').addClass('btn btn-sm btn-primary');
        $('.buttons-print').addClass('btn btn-sm btn-primary');
    }

  });