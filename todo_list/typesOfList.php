<?php
require 'vendor/autoload.php';
$obj= new Information();
if (isset($_GET)){
    $obj->types_task_list($_GET);
}
?>