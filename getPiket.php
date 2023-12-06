<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/src/dbConnect.php';
require_once __DIR__ . '/src/jsonHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') :
 

        $sql = "SELECT * FROM piket";
        $query = mysqli_query($conn, $sql);


        $array = array(); // define array
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                $array[] = $row; // Inside while loop
        }
        jsonHandler(200,'',$array);


   endif;
jsonHandler(405, 'HTTP Methode dalam endpoint ini harus GET!');