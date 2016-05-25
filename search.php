<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Too light || link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css' -->
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>


<?php

include('config/config.php');

if(!$u->isLoggedIn()) header('Location: index.php');

if(isset($_POST['btn-submit-search']))
{
    if(empty($_POST['inputName'])) $empty = 'Please complete all the fields.';

    else $arr = $u->getUsersByName($_POST['inputName']);
}

?>


<title><?php if($u->isLoggedIn()) echo $_SESSION['fName'].' '.$_SESSION['lName']; else echo TITLE; ?> </title>

<style>

    body
    {
        font-family: 'Abel', sans-serif;
        text-decoration: double;
    }

    .main
    {
        width: 80%;
        margin: 0 auto;
    }

    .banner
    {
        border-radius: 10px;
        height: 10%;
        text-align: center;
    }

    #nav
    {
        margin-top: .5%;
    }

    .btn-file
    {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file]
    {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    .footer
    {
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

</style>

<body>

<div class = "main">

    <div class = "banner">

        <h1 style = "padding: 1% 1%;"> My social networking site</h1>
        <hr />

    </div>

    <div class = "content">

        <nav class = "navbar navbar-default" id = "nav">
            <div class = "container-fluid" style = "padding: 1%;">
                <ul class="nav nav-pills">
                    <li><a href="index.php">Home</a></li>
                    <?php if($u->isLoggedIn()) echo '
                    <li class = "active"><a href="#">Search</a></li>

                    <li><a href = "requests.php">Friends</a></li>
                    <li><a href = "logout.php">Logout</a></li>
                    ';
                    else echo '<li><a href = "login.php">Login</a></li>';
                    ?>
    </ul>
    </div>

    </nav>

    </div>


    <div class = "well col-md-6">

        Search for user:
        <br><br>
        <?php
        if(isset($empty)) echo '<div class="alert alert-danger" style = "width: 40%;" role="alert">'. $empty . '</div><br>';
        ?>

        <form method = "post">
            <input type = "text" name = "inputName" class = "form-control">
            <br>
            <input type = "submit" name = "btn-submit-search" class = "btn btn-primary">

         </form>

     </div>
    <?php if(isset($arr))
    {

        echo '

        <div class = "well col-md-5" style="margin-left: 3%;">
        <h1>Results: </h1>

        <ul>
        ';


        foreach ($arr as $user) {
            echo '<li><a href = "profile.php?email=' . $user['email'] . '">' . $user['fName']. ' '. $user['lName'] . '</a></li>';
        }

        echo '
        </ul>

         </div>' ;
    }
    ?>

    <div class = "col-md-12 footer">
        <br>
        <hr>
        <br>

        <small><strong>This site is owned by Suvam Mohanty. The rules for usage of this site have been given <a href = "#">here.</a></strong></small>
    </div>

    </div>
</body>
</html>