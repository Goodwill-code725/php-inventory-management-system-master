$(document).ready(function() {
    var table = $('#manageProductTable').DataTable({
        "ajax": "php_action/fetch_productmanage.php",
        "columns": [
            { "data": "product_id" },
            { "data": "product_name" },
            { "data": "ingredient_name" },
            { "data": "ingredient_quantity" },
            { "data": "ingredient_cost" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<button class="btn btn-primary btn-sm" onclick="editIngredient(' + row.id + ')">View Details</button>';  
                    // Notice: now using row.id (not row.product_id)
                }
            }
        ]
    });

    // Expose the table for global reload
    window.reloadTable = function() {
        table.ajax.reload(null, false); // false = don't reset pagination
    };
});
