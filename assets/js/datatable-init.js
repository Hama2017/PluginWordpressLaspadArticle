jQuery(function($) {
    console.log("Datatable initialized");
    $('#articles-datatable').DataTable({
        paging: true,
        ordering: true,
        info: true,
        searching: true,        
    });
});
