<?php

include "../includes/db.php";
include "functions.php";

ob_start();
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: ../index.php");
}

// if($_SESSION['user_role'] !== 'admin') {
//     header("Location: ../index.php");
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

</head>

<body>
<!-- <div id='load-screen'>
    <div id='loading'></div>
</div> -->