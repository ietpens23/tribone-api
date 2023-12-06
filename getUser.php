<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: access');
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    header('HTTP/1.1 200 OK');
    die();
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/src/dbConnect.php';
require_once __DIR__ . '/src/jwtHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') :
    $headers = getallheaders();
    if (array_key_exists('Authorization', $headers) && preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) :
        $data = decodeToken($matches[1]);
        $userId = (int) $data;
        if (!is_numeric($data)) jsonHandler(401, 'User tidak valid!');
        $sql = "SELECT `id`, `nrp`, `nama`, `email`, `profile` FROM `users` WHERE `id`='$userId'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        if ($row === null) jsonHandler(404, 'User tidak ditemukan!');
        jsonHandler(200, '', $row);
    endif;
    jsonHandler(403, "Authorization Token salah!");

endif;

jsonHandler(405, 'HTTP Methode dalam endpoint ini harus GET!');
