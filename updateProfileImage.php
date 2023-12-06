<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: access');
    header('Access-Control-Allow-Methods: PUT');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header('HTTP/1.1 200 OK');
    die();
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: PUT');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/src/dbConnect.php';
require_once __DIR__ . '/src/jwtHandler.php';
require_once __DIR__ . '/src/jsonHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $headers = getallheaders();
    if (array_key_exists('Authorization', $headers) && preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) :
        $data = decodeToken($matches[1]);
        $userId = (int) $data;
        if (!is_numeric($data)) jsonHandler(401, 'User tidak valid!');

        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_name = $_FILES['photo']['name'];

        move_uploaded_file($photo_tmp, 'profile_img/' . $photo_name);

        // if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        //     $url = "https://";
        // } else {
        //     $url = "http://";
        // }
        // // Fix 
        // if (dirname($_SERVER['PHP_SELF']) == "/" || dirname($_SERVER['PHP_SELF']) == "\\") {
        //     $photo_name . $_SERVER['HTTP_HOST'];
        // } else {
        //     $photo_name . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/profile_img/' . $photo_name;
        // }

        $photodir = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "/")) . '/profile_img/' . $photo_name;
        $sql = "UPDATE `users` SET `profile` = '$photodir' WHERE `id` = '$userId'";
        $query = mysqli_query($conn, $sql);
        if ($query) jsonHandler(200, $photodir);
        jsonHandler(500, 'Terjadi kesalahan.');

    endif;
    jsonHandler(403, "Authorization Token salah!");

endif;

jsonHandler(405, 'HTTP method untuk request harus POST');
