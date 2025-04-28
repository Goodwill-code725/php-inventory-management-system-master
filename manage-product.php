<?php
require_once 'includes/header.php';
?>

<!-- Include jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Your Custom JavaScript -->
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
                    <button class="btn btn-default" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal">
                        <i class="glyphicon glyphicon-plus-sign"></i> Add Product
                    </button>
                </div>

                <table class="table" id="manageProductTable">
                    <thead>
                        <tr>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Ingredient Name</th>
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


