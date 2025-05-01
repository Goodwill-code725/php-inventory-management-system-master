<?php
require_once 'includes/header.php';
?>
<!-- DataTables CSS (optional if you use it) -->
<link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="assests/bootstrap/js/bootstrap.min.js"></script>

<!-- Your Custom JS -->
<script src="custom/js/productmanage.js"></script>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
            <li class="active">Product Management</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="page-heading">
                    <i class="glyphicon glyphicon-edit"></i> Manage Products
                </div>
            </div>

            <div class="panel-body">
                <div class="remove-messages"></div>
                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    
                </div>

                <table class="table" id="manageProductTable">
                    <thead>
                        <tr>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th style="width:15%;">Options</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal for View Details -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <!-- In Bootstrap 3, modal header titles use <button type="button" class="close" data-dismiss="modal"> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="viewDetailsModalLabel">Product Details</h4>
      </div>
      <div class="modal-body" id="viewDetailsContent">
        <!-- Product Details Here -->
      </div>
    </div>
  </div>
</div>

<?php
require_once 'includes/footer.php';
?>
