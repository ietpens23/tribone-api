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

        $id = trim($data->id);
        $rincian = trim($data->rincian);
        $tangal = trim($data->tangal);
        $total = trim($data->total);
        
       
        
        $sql = "UPDATE `kaskeluar` SET `rincian` = '$rincian', `tangal` = '$tangal', `total` = '$total' WHERE `kas`.`id` = '$id'";
        $query = mysqli_query($conn, $sql);
        if ($query) jsonHandler(200, 'kas kelas berhasil diupdate');
        jsonHandler(500, 'Terjadi kesalahan.');

    endif;
    jsonHandler(403, "Authorization Token salah!");

endif;

jsonHandler(405, 'HTTP method untuk request harus PUT');
