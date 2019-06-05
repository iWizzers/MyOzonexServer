<?php
$dir_name = 'update';
$version = file_get_contents($dir_name . '/version');
$zip_name = 'app.tar';
$zip = $dir_name . '/' . $zip_name;

if (file_exists($zip) AND isset($_GET['version'])) {
  if ($version != $_GET['version']) {
    /*header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"" . basename($zip_name) . "\"");*/
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zip_name);
    header('Content-Length: ' . filesize($zip));
    readfile($zip);
  }
}
?>