<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/src/dbConnect.php';
require_once __DIR__ . '/src/jwtHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $data = json_decode(file_get_contents('php://input'));

    if (
        !isset($data->email) ||
        !isset($data->password) ||
        empty(trim($data->email)) ||
        empty(trim($data->password))
    ) :
        jsonHandler(
            422,
            'Form yang diperlukan tidak lengkap.',
            ['required_fields' => ['email', 'password']]
        );
    endif;

    $email = mysqli_real_escape_string($conn, trim($data->email));
    $password = trim($data->password);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) :
        jsonHandler(422, 'Email address tidak sesuai format');

    elseif (strlen($password) < 8) :
        jsonHandler(422, 'Password harusnya 8 karakter atau lebih');
    endif;

    $sql = "SELECT * FROM `users` WHERE `email`='$email'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    if ($row === null) jsonHandler(404, 'User tidak ditemukan!');
    if (!password_verify($password, $row['password'])) jsonHandler(401, 'Password yang dimasukkan salah!');
    jsonHandler(200, '', [
        'token' => encodeToken($row['id'])
    ]);

jsonHandler(405, 'Invalid Request Method. HTTP method should be POST');
endif
?>