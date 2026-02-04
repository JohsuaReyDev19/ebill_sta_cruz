<?php
require '../db/dbconn.php';

/* Active Users */
$sqlActive = "SELECT COUNT(*) AS total_active 
              FROM users 
              WHERE status = 1 AND deleted = 0";
$active = $con->query($sqlActive)->fetch_assoc()['total_active'];

/* Pending Users */
$sqlPending = "SELECT COUNT(*) AS total_pending 
               FROM users 
               WHERE status = 0 AND deleted = 0";
$pending = $con->query($sqlPending)->fetch_assoc()['total_pending'];

/* Declined Users */
$sqlDeclined = "SELECT COUNT(*) AS total_declined 
                FROM users 
                WHERE status = 2 AND deleted = 0";
$declined = $con->query($sqlDeclined)->fetch_assoc()['total_declined'];
?>



<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                        Active Users
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $active ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-users text-primary fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                        Pending Users
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $pending ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-gauge text-primary fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                        Declined Users
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $declined ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-user-xmark text-primary fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

