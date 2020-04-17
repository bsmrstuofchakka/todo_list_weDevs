<?php
    require 'vendor/autoload.php';
    $obj= new Information();
    if (isset($_POST)){
        $obj->edit_task($_POST);
    }
?>