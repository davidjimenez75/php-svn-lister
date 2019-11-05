<?php
/*
 * API
 *
 * @revision  21
 */

require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $file=$_GET['file'];
    $data = file_get_contents('php://input');
    $fp = fopen($file, 'w+');
    fwrite($fp, $data);
    fclose($fp);
    //echo "GRABANDO EN: " . $_GET['file'] . " EL CONTENIDO: " . $data;
}