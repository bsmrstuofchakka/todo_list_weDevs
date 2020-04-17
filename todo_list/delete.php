<?php
    require 'vendor/autoload.php';

    if (isset($_GET['id'])){
        $id= $_GET['id'];
        $obj= new Information();
        $obj->delete_task($id);
    }
?>