<?php 
  //error_reporting(0);
  session_start();

  //ehco "logged_username : ".$_SESSION["logged_username"];

  include_once('base_functions.php'); 

  if( isset($_SESSION["logged_username"]) ){
    echo "<script>window.location='".base_url("dashboard.php")."';</script>"; 
  }
  
  
?> 
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>OLV App</title>

    <style>
      
    </style>
  </head>
  <body>

    <?php 

      if( $_SERVER['SCRIPT_NAME'] != '/olv/login.php') {
        include_once('menu.php');
      }

      // if( isset($_SESSION["logged_username"] ) ){
      //   include_once('menu.php');
      // }
    ?>