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

if ($_SERVER['REQUEST_METHOD'] == 'PUT') :
    $data = json_decode(file_get_contents('php://input'));
    $headers = getallheaders();
    if (array_key_exists('Authorization', $headers) && preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) :
        $datajwt = decodeToken($matches[1]);
        $userId = (int) $datajwt;
        if (!is_numeric($datajwt)) jsonHandler(401, 'User tidak valid!');

        $pass = trim($data->pass);
        $confpass = trim($data->confpass);

        if ($pass != $confpass) :
            jsonHandler(422, 'Password dan konfirmasi password tidak cocok');

        elseif (strlen($pass) < 8) :
            jsonHandler(422, 'Password kurang dari 8 karakter');

        endif;

        $hash_password = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "UPDATE `users` SET `password` = '$hash_password' WHERE `id` = '$userId'";
        $query = mysqli_query($conn, $sql);
        if ($query) jsonHandler(200, 'Password berhasil diubah');
        jsonHandler(500, 'Terjadi kesalahan.');

    endif;
    jsonHandler(403, "Authorization Token salah!");

endif;

jsonHandler(405, 'HTTP method untuk request harus PUT');
