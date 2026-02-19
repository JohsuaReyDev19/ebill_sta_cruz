<?php
date_default_timezone_set('Asia/Manila');
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $is_institution = isset($_POST['is_organization']) ? 1 : 0;

    // Common fields
    $same_address = isset($_POST['sameAddressCheck']) ? mysqli_real_escape_string($con, $_POST['sameAddressCheck']) : '';
    $home_citytown = isset($_POST['home_citytown']) ? mysqli_real_escape_string($con, $_POST['home_citytown']) : '';
    $home_barangay = isset($_POST['home_barangay']) ? mysqli_real_escape_string($con, $_POST['home_barangay']) : '';
    $home_sitio = isset($_POST['home_sitio']) ? mysqli_real_escape_string($con, $_POST['home_sitio']) : '';
    $home_street = isset($_POST['home_street']) ? mysqli_real_escape_string($con, $_POST['home_street']) : '';
    $home_house_no = isset($_POST['home_house_no']) ? mysqli_real_escape_string($con, $_POST['home_house_no']) : '';
    $billing_citytown = isset($_POST['billing_citytown']) ? mysqli_real_escape_string($con, $_POST['billing_citytown']) : '';
    $billing_barangay = isset($_POST['billing_barangay']) ? mysqli_real_escape_string($con, $_POST['billing_barangay']) : '';
    $billing_sitio = isset($_POST['billing_sitio']) ? mysqli_real_escape_string($con, $_POST['billing_sitio']) : '';
    $billing_street = isset($_POST['billing_street']) ? mysqli_real_escape_string($con, $_POST['billing_street']) : '';
    $billing_house_no = isset($_POST['billing_house_no']) ? mysqli_real_escape_string($con, $_POST['billing_house_no']) : '';
    $contact_no = isset($_POST['contact_no']) ? mysqli_real_escape_string($con, $_POST['contact_no']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($con, $_POST['email']) : '';
    $date_added = date('Y-m-d H:i:s');

    // =========================
    // PROFILE UPLOAD
    // =========================
    $profile_uploaded = true;
    $file_name = '';

    if (!empty($_FILES['profile']['name'])) {

        $file = $_FILES['profile'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $unique_id = uniqid();
        $file_name = $unique_id . '_profile.' . $file_extension;
        $file_tmp = $file['tmp_name'];
        $file_destination = "../../upload/profile/" . $file_name;

        if ($file['size'] > 1048576) {

            if ($file_extension == "jpg" || $file_extension == "jpeg") {
                $src = imagecreatefromjpeg($file_tmp);
            } elseif ($file_extension == "png") {
                $src = imagecreatefrompng($file_tmp);
            } elseif ($file_extension == "gif") {
                $src = imagecreatefromgif($file_tmp);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Unsupported image format.']);
                exit;
            }

            $width = imagesx($src);
            $height = imagesy($src);
            $max_width = 800;

            if ($width > $max_width) {
                $new_width = $max_width;
                $new_height = floor($height * ($max_width / $width));
                $tmp = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                $src = $tmp;
            }

            if ($file_extension == "png") {
                imagepng($src, $file_destination, 8);
            } else {
                imagejpeg($src, $file_destination, 75);
            }

            imagedestroy($src);

        } else {
            if (!move_uploaded_file($file_tmp, $file_destination)) {
                echo json_encode(['status' => 'error', 'message' => 'Profile image upload failed.']);
                exit;
            }
        }
    }

    if ($profile_uploaded) {

        // =========================
        // INSTITUTION
        // =========================
        if ($is_institution) {

            $institution_name = mysqli_real_escape_string($con, $_POST['institution_name'] ?? '');
            $institution_description = mysqli_real_escape_string($con, $_POST['institution_description'] ?? '');

            $sql_concessionaire = "INSERT INTO concessionaires (
                last_name, first_name, middle_name, suffix_name, gender,
                institution_name, institution_description, is_institution,
                same_address, home_citytownmunicipality_id, home_barangay_id, home_sitio, home_street, home_housebuilding_no,
                billing_citytownmunicipality_id, billing_barangay_id, billing_sitio, billing_street, billing_housebuilding_no,
                contact_no, email, date_added, profile
            ) VALUES (
                '', '', '', '', '',
                '$institution_name', '$institution_description', 1,
                '$same_address', '$home_citytown', '$home_barangay', '$home_sitio', '$home_street', '$home_house_no',
                '$billing_citytown', '$billing_barangay', '$billing_sitio', '$billing_street', '$billing_house_no',
                '$contact_no', '$email', '$date_added', '$file_name'
            )";

        } else {

            // =========================
            // INDIVIDUAL
            // =========================

            $last_name = mysqli_real_escape_string($con, $_POST['last_name'] ?? '');
            $first_name = mysqli_real_escape_string($con, $_POST['first_name'] ?? '');
            $middle_name = mysqli_real_escape_string($con, $_POST['middle_name'] ?? '');
            $suffix_name = mysqli_real_escape_string($con, $_POST['suffix_name'] ?? '');
            $gender = mysqli_real_escape_string($con, $_POST['gender'] ?? '');
            // $discount = mysqli_real_escape_string($con, $_POST['discount'] ?? '');
            $id_number = mysqli_real_escape_string($con, $_POST['id_number'] ?? '');

            // ✅ FIXED CHECKBOX HANDLING (0 or 1)
            $discount = isset($_POST['discount']) ? 'Pwd' : NULL;

            $sql_concessionaire = "INSERT INTO concessionaires (
                last_name, first_name, middle_name, suffix_name, gender,
                institution_name, institution_description, is_institution,
                same_address, home_citytownmunicipality_id, home_barangay_id, home_sitio, home_street, home_housebuilding_no,
                billing_citytownmunicipality_id, billing_barangay_id, billing_sitio, billing_street, billing_housebuilding_no,
                contact_no, email, date_added, profile,
                discount, id_number
            ) VALUES (
                '$last_name', '$first_name', '$middle_name', '$suffix_name', '$gender',
                '', '', 0,
                '$same_address', '$home_citytown', '$home_barangay', '$home_sitio', '$home_street', '$home_house_no',
                '$billing_citytown', '$billing_barangay', '$billing_sitio', '$billing_street', '$billing_house_no',
                '$contact_no', '$email', '$date_added', '$file_name',
                '$discount', '$id_number'
            )";
        }

        if (mysqli_query($con, $sql_concessionaire)) {
            echo json_encode(['status' => 'success', 'message' => 'Concessionaire added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => mysqli_error($con)]);
        }
    }
}

mysqli_close($con);
?>
