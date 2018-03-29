<?php
/**
 * Created by PhpStorm.
 * User: bbrody
 * Date: 27.03.2018
 * Time: 17:51
 */

$path = dirname(__FILE__);
$log_files = array_diff(scandir($path), ['.', '..', 'index.php']);
$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/logs/";


if ($_GET['file']) {

    echo "<pre>";
    require_once $_GET['file'];
    echo "</pre>";

} else {
    echo "Log files:<br/>";

    foreach ($log_files as $file) {
        echo "<a href='$current_url" . "?file=$file'>$file</a><br/>";
    }

}


