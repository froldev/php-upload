<?php

$filename = $_GET['name'];

if (file_exists($filename)) {
    unlink($filename);
}
header('location:/index.php');
