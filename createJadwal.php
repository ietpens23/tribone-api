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
require_once __DIR__ . '/src/jwtHandler.php';
require_once __DIR__ . '/src/jsonHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $data = json_decode(file_get_contents('php://input'));
    $headers = getallheaders();
    if (array_key_exists('Authorization', $headers) && preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) :
        $datajwt = decodeToken($matches[1]);
        $userId = (int) $datajwt;
        if (!is_numeric($datajwt)) jsonHandler(401, 'User tidak valid!');

        if (
            !isset($data->hari) ||
            !isset($data->matkul) ||
            !isset($data->dosen) ||
            !isset($data->ruang) ||
            !isset($data->jam) ||
            !isset($data->semester) ||
            empty(trim($data->hari)) ||
            empty(trim($data->matkul)) ||
            empty(trim($data->dosen)) ||
            empty(trim($data->ruang)) ||
            empty(trim($data->jam)) ||
            empty(trim($data->semester))
        ) :
            jsonHandler(
                422,
                'Form yang diperlukan tidak lengkap.',
                ['required_fields' => ['hari', 'matkul', 'dosen', 'ruang', 'jam', 'semester']]
            );
        endif;

        $hari = trim($data->hari);
        $matkul = trim($data->matkul);
        $dosen = mysqli_real_escape_string($conn, htmlspecialchars(trim($data->dosen)));
        $ruang = trim($data->ruang);
        $jam = mysqli_real_escape_string($conn, htmlspecialchars(trim($data->jam)));
        $semester = trim($data->semester);

        $sql = "SELECT `matkul` FROM `schedule` WHERE `matkul`='$matkul'";
        $query = mysqli_query($conn, $sql);
        $row_num = mysqli_num_rows($query);
        if ($row_num > 0) jsonHandler(422, 'Mata kuliah sudah pernah ditambahkan');

        $sql = "INSERT INTO `schedule`(`hari`, `matkul`,`dosen`,`ruang`,`jam`,`semester`) VALUES('$hari', '$matkul','$dosen','$ruang','$jam','$semester')";
        $query = mysqli_query($conn, $sql);
        if ($query) jsonHandler(200, 'Mata kuliah berhasil ditambahkan');
        jsonHandler(500, 'Terjadi kesalahan.');

    endif;
    jsonHandler(403, "Authorization Token salah!");

endif;

jsonHandler(405, 'HTTP method untuk request harus POST');
?>