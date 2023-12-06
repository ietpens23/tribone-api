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
        !isset($data->nrp) ||
        !isset($data->nama) ||
        !isset($data->email) ||
        !isset($data->password) ||
        empty(trim($data->nrp)) ||
        empty(trim($data->nama)) ||
        empty(trim($data->email)) ||
        empty(trim($data->password))
    ) :
        jsonHandler(
            422,
            'Form yang diperlukan tidak lengkap.',
            ['required_fields' => ['nrp', 'nama', 'email', 'password']]
        );
    endif;

    $nrp = trim($data->nrp);
    $nama = mysqli_real_escape_string($conn, htmlspecialchars(trim($data->nama)));
    $email = mysqli_real_escape_string($conn, trim($data->email));
    $password = trim($data->password);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        jsonHandler(422, 'Email tidak sesuai format');

    elseif (strlen($password) < 8) :
        jsonHandler(422, 'Password kurang dari 8 karakter');

    // elseif (strlen($nama) < 4) :
    //     jsonHandler(422, 'Nama terlalu pendek');

    endif;

    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT `nama` FROM `users` WHERE `nama`='$nama'";
    $query = mysqli_query($conn, $sql);
    $row_num = mysqli_num_rows($query);
    if ($row_num > 0) jsonHandler(422, 'Nama sudah terdaftar');

    $sql = "INSERT INTO `users`(`nrp`, `nama`,`email`,`password`) VALUES('$nrp', '$nama','$email','$hash_password')";
    $query = mysqli_query($conn, $sql);
    if ($query) jsonHandler(200, 'Registrasi berhasil');
    jsonHandler(500, 'Terjadi kesalahan.');
endif;

jsonHandler(405, 'HTTP method untuk request harus POST')
?>