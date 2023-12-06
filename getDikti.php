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

require_once __DIR__ . '/src/jsonHandler.php';

$data = json_decode(file_get_contents('php://input'));

function callPddikti($data)
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, "https://api-frontend.kemdikbud.go.id/hit_mhs/$data");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($curl);
    if (!$output) {
        die("Gagal menghubungkan ke API PDDIKTI");
    }
    curl_close($curl);
    return $output;
}

$data = json_decode(file_get_contents('php://input'));

if (
    !isset($data->data) ||
    empty(trim($data->data))
) :
    jsonHandler(
        422,
        'Masukkan data mahasiswa.',
        ['required_fields' => ['data']]
    );
endif;

$data = trim($data->data);

$result = callPddikti($data);
echo $result;
