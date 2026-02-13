<?php
require '../../db/dbconn.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $zonebook_id   = mysqli_real_escape_string($con, $_POST['zonebook_id'] ?? '');
    $meter_size_id = mysqli_real_escape_string($con, $_POST['meter_size_id'] ?? '');
    $classification = mysqli_real_escape_string($con, $_POST['classification'] ?? '');

    if (!$zonebook_id || !$meter_size_id || !$classification) {
        $response = ['status' => 'error', 'message' => 'Zone, Meter Size or Classification missing.'];
    } else {

        // Zone Code (3 digits)
        $zoneQuery = mysqli_query($con, "SELECT zonebook FROM zonebook_settings WHERE zonebook_id = '$zonebook_id'");
        $zoneRow = mysqli_fetch_assoc($zoneQuery);
        $zoneCode = str_pad($zoneRow['zonebook'], 3, '0', STR_PAD_LEFT);

        // Meter Size
        $meterQuery = mysqli_query($con, "SELECT meter_size FROM meter_size_settings WHERE meter_size_id = '$meter_size_id'");
        $meterRow = mysqli_fetch_assoc($meterQuery);
        $meterSize = $meterRow['meter_size'];

        $classification_name = $con->query("SELECT classification FROM classification_settings WHERE classification_id='$classification'")
        ->fetch_assoc()['classification'] ?? '';

        $code = 0;
        if($classification_name == "RESIDENTIAL" || $classification_name == "GOVERNMENT"){
            $code = 1;
        }elseif($classification_name == "COMMERCIAL C"){
            $code = 2;
        }elseif($classification_name == "COMMERCIAL B"){
            $code = 3;
        }elseif($classification_name == "COMMERCIAL A"){
            $code = 4;
        }elseif($classification_name == "COMMERCIAL / INDUSTRIAL"){
            $code = 5;
        }

        // Meter Code Mapping
        $meterMap = [
            "1/2" => "A",
            "1 1/2" => "B",
            "1" => "B",
            "2" => "C",
            "2 1/2" => "C",
            "3" => "D",
            "3 1/2" => "D",
            "4" => "E",
            "4 1/2" => "E"
        ];

        $meterCode = $meterMap[$meterSize] ?? str_pad($meterSize, 2, '0', STR_PAD_LEFT);

        // Correct Pattern for this specific zone-code-meter combination
        $likePattern = "$zoneCode-$code$meterCode-%";

        $seriesQuery = mysqli_query($con, "
            SELECT account_no 
            FROM meters 
            WHERE account_no LIKE '$likePattern'
            ORDER BY account_no DESC 
            LIMIT 1
        ");

        if (mysqli_num_rows($seriesQuery) > 0) {
            $last = mysqli_fetch_assoc($seriesQuery);
            $lastSeries = intval(substr($last['account_no'], -3));
            $newSeries = $lastSeries + 1;
        } else {
            $newSeries = 1;
        }

        $seriesCode = str_pad($newSeries, 3, '0', STR_PAD_LEFT);

        // FINAL ACCOUNT NUMBER (MATCHES PATTERN)
        $account_no = "$zoneCode-$code$meterCode-$seriesCode";

        $response = [
            'status' => 'success',
            'account_no' => $account_no
        ];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request.'];
}

header('Content-Type: application/json');
echo json_encode($response);
mysqli_close($con);