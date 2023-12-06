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
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/src/dbConnect.php';
require_once __DIR__ . '/src/jsonHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $data = json_decode(file_get_contents('php://input'));

    if (
        !isset($data->hari) ||  
        !isset($data->ruangan) ||
        !isset($data->nama) ||
        empty(trim($data->hari)) ||
        empty(trim($data->ruangan)) ||
        empty(trim($data->nama)) 
    ) :
        jsonHandler(
            422,
            'Form yang diperlukan tidak lengkap.',
            ['required_fields' => ['hari', 'ruangan', 'nama']]
        );
    endif;

    $hari = trim($data->hari);
    $nama = mysqli_real_escape_string($conn, htmlspecialchars(trim($data->nama)));
    $ruangan = mysqli_real_escape_string($conn, htmlspecialchars(trim($data->ruangan)));
    

    $sql = "SELECT `hari` FROM `piket` WHERE `ruangan`='$ruangan'";
    $query = mysqli_query($conn, $sql);
    $row_num = mysqli_num_rows($query);
    if ($row_num > 0) jsonHandler(422, 'ruangan sudah pernah di tambahakan');

    $sql = "INSERT INTO `piket`(`hari`, `ruangan`,`nama`) VALUES('$hari', '$ruangan','$nama')";
    $query = mysqli_query($conn, $sql);
    if ($query) jsonHandler(200, 'Jadwal piket berhasil ditambahkan');
    jsonHandler(500, 'Terjadi kesalahan.');

endif;

jsonHandler(405, 'HTTP method untuk request harus POST');
?>