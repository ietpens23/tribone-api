<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/src/dbConnect.php';
require_once __DIR__ . '/src/jsonHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') :
 

        $sql = "SELECT SUM(agustus) as total_agustus, SUM(september) as total_september,SUM(oktober) as total_oktober,SUM(november) as total_november,SUM(desember) as total_desember FROM kas";
        $query = mysqli_query($conn, $sql);
        // $result = $conn->query($query);


        // $array = array(); // define array
        // while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        //         $array[] = $row; // Inside while loop
        // }
        // echo json_encode(array($array));
        // jsonHandler(200,'',$array);
       
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        // $total_agustus = $row['total_agustus'];
        // $total_september = $row['total_september'];
        echo json_encode($row);


   endif;
// jsonHandler(405, 'HTTP Methode dalam endpoint ini harus GET!');