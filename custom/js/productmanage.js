// Ensure this is in custom/js/productmanage.js
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#manageProductTable')) {
        $('#manageProductTable').DataTable().clear().destroy();
    }

    var table = $('#manageProductTable').DataTable({
        "ajax": "php_action/fetch_productmanage.php",
        "columns": [
            { "data": "product_id" },
            { "data": "product_name" },
            { "data": "quantity" },
            { "data": "rate" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<button class="btn btn-primary btn-sm" onclick="editIngredient(' + row.product_id + ')">View Details</button>';
                }
            }
        ]
    });

    window.reloadTable = function() {
        table.ajax.reload(null, false);
    };
});






// JavaScript function for editing ingredient details
function editIngredient(product_id) {
    $.ajax({
        url: 'php_action/fetch_ingredient_details.php',
        type: 'POST',
        data: { product_id: product_id },  // Pass the product_id
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#viewDetailsContent').html(response.details);
                $('#viewDetailsModal').modal('show');
            } else {
                alert("Failed to load product details: " + response.error);
            }
        },
        error: function(xhr, status, error) {
            alert("Error occurred: " + error);
        }
    });
}

