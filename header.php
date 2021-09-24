<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MelTravel</title>
    <script src="lib/js/jquery-3.1.1.js"></script>
    <script src="lib/js/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="lib/css/style.css" >
</head>
<body>
    <div class="wrap">
        <div class="header">
            <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-header-custom shadow-sm">
                <h5 class="my-0 mr-md-auto font-weight-normal logo"><a href="index.php">Abc</a></h5>
                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 text-white" href="index.php">Home</a>
                    <a class="p-2 text-dark" href="index.php?page=services">Services</a>
                    <a class="p-2 text-dark" href="index.php?page=mytravel">booking</a>
                    <a class="p-2 text-dark" href="index.php?page=contact-us">Contact us</a>
                    <?php if(!isset($_SESSION['USER'])){ ?><a class="p-2 text-dark" href="index.php?page=register">Register</a><?php }?>
                    <?php if(!isset($_SESSION['USER'])){ ?>
                        <a class="p-2 text-dark" href="index.php?page=login">Login</a>
                    <?php }else{ ?>
                        <a class="p-2 text-dark" href="logout.php">Logout</a>
                    <?php } ?>
                </nav>
            </div>
        </div>