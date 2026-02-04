<?php 
require 'function/check_session.php';

// Call the checkSession function to perform session validation
checkSession();
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>e-Billing - Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../img/mmwd.png">

    <!-- script for dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="../css/multiform.css">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Font awesome cdn -->
    <script src="https://kit.fontawesome.com/a5fa2fa3ce.js" crossorigin="anonymous"></script>

    <!-- datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" integrity="sha256-h2Gkn+H33lnKlQTNntQyLXMWq7/9XI2rlPCsLsVcUBs=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js" integrity="sha256-+0Qf8IHMJWuYlZ2lQDBrF1+2aigIRZXEdSvegtELo2I=" crossorigin="anonymous"></script>

    <link href="../vendor/lightbox2/dist/css/lightbox.css" rel="stylesheet" />
    <!-- Include Selectize.js and jQuery -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    
    
    <style>
        .input-error {
            border: 1px solid red !important;
        }
        .readonly-select {
            pointer-events: none; /* Prevent user interaction */
            background-color: #e9ecef; /* Light grey background to look disabled */
            color: #6c757d; /* Grey text */
        }
        #btnPrint:hover{
            color: black;
        }
    /* Make table text smaller */
    #readingSheetTable {
        font-size: 12px;
    }

    /* Reduce cell padding */
    #readingSheetTable th,
    #readingSheetTable td {
        padding: 4px 6px !important;
        vertical-align: middle !important;
        white-space: nowrap;
        color: black;
    }

    /* Smaller checkbox */
    #readingSheetTable input[type="checkbox"] {
        transform: scale(0.85);
    }

    /* Smaller input fields inside table */
    #readingSheetTable input,
    #readingSheetTable select {
        height: 24px;
        font-size: 12px;
        padding: 2px 4px;
    }
</style>


</head>