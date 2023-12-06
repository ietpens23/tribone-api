<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/src/dbConnect.php';
require_once __DIR__ . '/src/jsonHandler.php';
                                        
if ($_SERVER['REQUEST_METHOD'] == 'GET') :
 

        $sql = "SELECT * FROM schedule";
        $query = mysqli_query($conn, $sql);

        // $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        // mysqli_free_result($result);
        // echo $result;

        $array = array(); // define array
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                $array[] = $row; // Inside while loop
        }
        jsonHandler(200,'',$array);
        // while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
        // {
        //         jsonHandler(200, '', $row['hari']);   
        //         $abc = $row['hari'];
        //         $abi = $row['dosen'];
        // }

        // while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        //         jsonHandler(200, $row);
        // }

        // if ($row === null) jsonHandler(404, 'Data tidak ditemukan!');
        // jsonHandler(200, '', $row);     

   endif;
jsonHandler(405, 'HTTP Methode dalam endpoint ini harus GET!');