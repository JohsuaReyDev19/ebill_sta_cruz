<?php
require '../../db/dbconn.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zonebook_id = mysqli_real_escape_string($con, $_POST['zonebook_id'] ?? '');
    $meter_size_id = mysqli_real_escape_string($con, $_POST['meter_size_id'] ?? '');

    if (!$zonebook_id || !$meter_size_id) {
        $response = ['status' => 'error', 'message' => 'Zone or Meter Size missing.'];
    } else {
        
        $zoneQuery = mysqli_query($con, "SELECT zonebook FROM zonebook_settings WHERE zonebook_id = '$zonebook_id'");
        $zoneRow = mysqli_fetch_assoc($zoneQuery);
        $zoneCode = str_pad($zoneRow['zonebook'], 3, '0', STR_PAD_LEFT);

        // 2 Meter Size Code (2 digits)
        $meterQuery = mysqli_query($con, "SELECT meter_size FROM meter_size_settings WHERE meter_size_id = '$meter_size_id'");
        $meterRow = mysqli_fetch_assoc($meterQuery);
        $meterCode = str_pad($meterRow['meter_size'], 2, '0', STR_PAD_LEFT);

        $meterNo =  $meterCode; 
        // Special handling for fractional sizes
        if ($meterCode == "1/2") {
            $meterCode = "12";
        } elseif ($meterCode == "1 1/2") {
            $meterCode = "112";
        } elseif ($meterCode == "2 1/2") {
            $meterCode = "212";
        }elseif($meterCode == "3 1/2"){
            $meterCode ="312";
        }elseif($meterCode == "4 1/2"){
            $meterCode = "412";
        }else{
            $meterCode = $meterNo;
        }

        $likePattern = "$zoneCode-$meterCode-%";
        $seriesQuery = mysqli_query($con, "SELECT account_no FROM meters WHERE account_no LIKE '$likePattern' ORDER BY account_no DESC LIMIT 1");

        if (mysqli_num_rows($seriesQuery) > 0) {
            $last = mysqli_fetch_assoc($seriesQuery);
            $lastSeries = intval(substr($last['account_no'], -3));
            $newSeries = $lastSeries + 1;
        } else {
            $newSeries = 1;
        }

        $seriesCode = str_pad($newSeries, 3, '0', STR_PAD_LEFT);
        $account_no = "$zoneCode-$meterCode-$seriesCode";

        $response = ['status' => 'success', 'account_no' => $account_no];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request.'];
}

header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);
