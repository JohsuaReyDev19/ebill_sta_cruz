<?php
session_start();
date_default_timezone_set('Asia/Manila');
require '../../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_FILES['system_profile']['name'])) {
        echo json_encode(['status' => 'error', 'message' => 'No image selected.']);
        exit;
    }

    $file = $_FILES['system_profile'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid image format.']);
        exit;
    }

    /* ==========================
       CREATE IMAGE RESOURCE
    ========================== */
    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $src = imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'png':
            $src = imagecreatefrompng($file['tmp_name']);
            break;
        case 'gif':
            $src = imagecreatefromgif($file['tmp_name']);
            break;
        case 'webp':
            $src = imagecreatefromwebp($file['tmp_name']);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Unsupported image type.']);
            exit;
    }

    if (!$src) {
        echo json_encode(['status' => 'error', 'message' => 'Image processing failed.']);
        exit;
    }

    /* ==========================
       RESIZE & CENTER CROP (300x300)
    ========================== */
    $srcWidth  = imagesx($src);
    $srcHeight = imagesy($src);
    $targetSize = 300;

    $srcRatio = $srcWidth / $srcHeight;

    if ($srcRatio > 1) {
        $newHeight = $targetSize;
        $newWidth  = intval($targetSize * $srcRatio);
    } else {
        $newWidth  = $targetSize;
        $newHeight = intval($targetSize / $srcRatio);
    }

    $temp = imagecreatetruecolor($newWidth, $newHeight);
    imagealphablending($temp, false);
    imagesavealpha($temp, true);
    $transparent = imagecolorallocatealpha($temp, 0, 0, 0, 127);
    imagefill($temp, 0, 0, $transparent);

    imagecopyresampled(
        $temp,
        $src,
        0, 0, 0, 0,
        $newWidth,
        $newHeight,
        $srcWidth,
        $srcHeight
    );

    $x = intval(($newWidth - $targetSize) / 2);
    $y = intval(($newHeight - $targetSize) / 2);

    $final = imagecreatetruecolor($targetSize, $targetSize);
    imagealphablending($final, false);
    imagesavealpha($final, true);
    imagefill($final, 0, 0, $transparent);

    imagecopy(
        $final,
        $temp,
        0, 0,
        $x, $y,
        $targetSize,
        $targetSize
    );

    imagedestroy($src);
    imagedestroy($temp);

    /* ==========================
       CREATE 120x120 PRELOADER
    ========================== */
    $preloaderSize = 120;
    $preloader = imagecreatetruecolor($preloaderSize, $preloaderSize);
    imagealphablending($preloader, false);
    imagesavealpha($preloader, true);
    imagefill($preloader, 0, 0, $transparent);

    imagecopyresampled(
        $preloader,
        $final,
        0, 0, 0, 0,
        $preloaderSize,
        $preloaderSize,
        $targetSize,
        $targetSize
    );

    /* ==========================
       SAVE FILES
    ========================== */
    $baseName = uniqid('system_');
    $mainName = $baseName . '.' . $ext;
    $preloaderName = $baseName . '_preloader.png';

    $mainPath = "../../img/" . $mainName;
    $preloaderPath = "../../img/" . $preloaderName;

    switch ($ext) {
        case 'png':
            imagepng($final, $mainPath, 8);
            break;
        case 'webp':
            imagewebp($final, $mainPath, 80);
            break;
        default:
            imagejpeg($final, $mainPath, 80);
    }

    imagepng($preloader, $preloaderPath, 8);

    imagedestroy($final);
    imagedestroy($preloader);

    /* ==========================
       UPDATE DATABASE & SESSION
    ========================== */
    $stmt = $con->prepare("UPDATE system_settings SET system_profile = ?, system_preloader = ? WHERE settings_id = 1");
    $stmt->bind_param("ss", $mainName, $preloaderName);

    if ($stmt->execute()) {
        $_SESSION['system_profile'] = $mainName;

        echo json_encode([
            'status' => 'success',
            'message' => 'System profile updated successfully.',
            'system_profile' => $mainName,
            'preloader' => $preloaderName
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database update failed.'
        ]);
    }

    $stmt->close();
    $con->close();
}
