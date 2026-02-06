<?php
// Set the time zone to Manila, Philippines
date_default_timezone_set('Asia/Manila');

// Include your database connection file
require '../../db/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $concessionaire_id = isset($_POST['concessionaire_id']) ? mysqli_real_escape_string($con, $_POST['concessionaire_id']) : '';

    // Detect if concessionaire is an institution
    $is_institution = isset($_POST['is_institution']) ? 1 : 0;

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

    // Handle profile upload
    $profile_uploaded = false;
    $file_name = '';

    if (!empty($_FILES['profile']['name'])) {
        $file = $_FILES['profile'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $unique_id = uniqid();
        $file_name = $unique_id . '_profile.' . $file_extension;
        $file_tmp = $file['tmp_name'];
        $file_destination = "../../upload/profile/" . $file_name;

        // Check file size > 1MB
        if ($file['size'] > 1048576) {
            // Compress/resize image
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

            // Resize (max 800px width, maintain aspect ratio)
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

            // Save compressed file
            if ($file_extension == "png") {
                imagepng($src, $file_destination, 8); // compression 0–9
            } else {
                imagejpeg($src, $file_destination, 75); // quality 0–100
            }
            imagedestroy($src);
            $profile_uploaded = true;
        } else {
            // Just move directly if <1MB
            if (move_uploaded_file($file_tmp, $file_destination)) {
                $profile_uploaded = true;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Profile image upload failed.']);
                exit;
            }
        }
    }

    // Build update query based on type
    if ($is_institution) {
        $institution_name = isset($_POST['institution_name']) ? mysqli_real_escape_string($con, $_POST['institution_name']) : '';
        $institution_description = isset($_POST['institution_description']) ? mysqli_real_escape_string($con, $_POST['institution_description']) : '';

        $sql = "UPDATE concessionaires SET
                    last_name = '',
                    first_name = '',
                    middle_name = '',
                    suffix_name = '',
                    gender = '',
                    institution_name = '$institution_name',
                    institution_description = '$institution_description',
                    is_institution = 1,
                    same_address = '$same_address',
                    home_citytownmunicipality_id = '$home_citytown',
                    home_barangay_id = '$home_barangay',
                    home_sitio = '$home_sitio',
                    home_street = '$home_street',
                    home_housebuilding_no = '$home_house_no',
                    billing_citytownmunicipality_id = '$billing_citytown',
                    billing_barangay_id = '$billing_barangay',
                    billing_sitio = '$billing_sitio',
                    billing_street = '$billing_street',
                    billing_housebuilding_no = '$billing_house_no',
                    contact_no = '$contact_no',
                    email = '$email'";

    } else {
        $last_name = isset($_POST['last_name']) ? mysqli_real_escape_string($con, $_POST['last_name']) : '';
        $first_name = isset($_POST['first_name']) ? mysqli_real_escape_string($con, $_POST['first_name']) : '';
        $middle_name = isset($_POST['middle_name']) ? mysqli_real_escape_string($con, $_POST['middle_name']) : '';
        $suffix_name = isset($_POST['suffix_name']) ? mysqli_real_escape_string($con, $_POST['suffix_name']) : '';
        $gender = isset($_POST['gender']) ? mysqli_real_escape_string($con, $_POST['gender']) : '';
        $discount = isset($_POST['discount']) ? mysqli_real_escape_string($con, $_POST['discount']) : '';

        $sql = "UPDATE concessionaires SET
                    last_name = '$last_name',
                    first_name = '$first_name',
                    middle_name = '$middle_name',
                    suffix_name = '$suffix_name',
                    gender = '$gender',
                    discount = '$discount',
                    institution_name = '',
                    institution_description = '',
                    is_institution = 0,
                    same_address = '$same_address',
                    home_citytownmunicipality_id = '$home_citytown',
                    home_barangay_id = '$home_barangay',
                    home_sitio = '$home_sitio',
                    home_street = '$home_street',
                    home_housebuilding_no = '$home_house_no',
                    billing_citytownmunicipality_id = '$billing_citytown',
                    billing_barangay_id = '$billing_barangay',
                    billing_sitio = '$billing_sitio',
                    billing_street = '$billing_street',
                    billing_housebuilding_no = '$billing_house_no',
                    contact_no = '$contact_no',
                    email = '$email'";
    }

    // Add profile if uploaded
    if ($profile_uploaded) {
        $sql .= ", profile = '$file_name'";
    }

    // Complete with WHERE
    $sql .= " WHERE concessionaires_id = '$concessionaire_id'";

    // Execute
    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Concessionaire updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating concessionaire: ' . mysqli_error($con)]);
    }
}

mysqli_close($con);
?>
