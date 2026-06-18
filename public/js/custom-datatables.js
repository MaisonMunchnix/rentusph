$(document).ready(function() {
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.datatable-enabled').each(function() {
            var table = $(this);
            
            // Check if already initialized to prevent double-initialization
            if ($.fn.DataTable.isDataTable(table)) {
                return;
            }

            var dtOptions = {
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [], // Do not enforce initial sort order, respect HTML markup order
                language: {
                    search: "",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    zeroRecords: "No matching records found",
                    emptyTable: "No data available in table",
                    paginate: {
                        next: '<i class="fas fa-chevron-right"></i>',
                        previous: '<i class="fas fa-chevron-left"></i>'
                    }
                }
            };

            // Automatically detect and disable sorting on headers containing "ACTION"
            var columns = [];
            table.find('thead th').each(function(index) {
                var thText = $(this).text().toUpperCase().trim();
                if (thText.includes('ACTION') || thText.includes('ACTIONS') || thText === '#' || thText === '') {
                    columns.push({ orderable: false, targets: index });
                }
            });

            if (columns.length > 0) {
                dtOptions.columnDefs = columns;
            }

            table.DataTable(dtOptions);
        });
    }
});
