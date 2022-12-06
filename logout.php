<?php
    include_once("base_functions.php");
    
    session_start();
    session_unset();
    session_destroy();
    
    echo "<script>window.location='".base_url()."';</script>";
?>