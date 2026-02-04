<?php
require './db/dbconn.php';

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

/* Archived Users */
$sqlArchived = "SELECT COUNT(*) AS total_archived 
                FROM users 
                WHERE deleted = 1";
$archived = $con->query($sqlArchived)->fetch_assoc()['total_archived'];
?>