<?php

include('config/config.php');

if($u->isLoggedIn()) header('Location: index.php');

if(isset($_POST['btn-submit-login']))
{
    if(empty($_POST['inputEmailLogin']) || empty($_POST['inputPasswordLogin'])) $empty = "Please complete ALL the fields.";
    else
    {
        if($u->login($_POST['inputEmailLogin'], $_POST['inputPasswordLogin']))
        {
            if($u->login($_POST['inputEmail'], $_POST['inputPassword']))
            {
                header('Location: index.php');
            }

        }
        else $empty = "Oops! Our service seems to be down. Sorry for the inconvenience.";
    }
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Too light || link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css' -->
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>

    <title><?php if($u->isLoggedIn()) header('Location: index.php'); else echo 'Login - '. TITLE; ?> </title>



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

        .footer
        {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }


        .bannerDiv
        {
            padding: 3%;
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
                    <li class="active"><a href = "#">Login</a></li>

                </ul>
            </div>

        </nav>

        <div class = "col-md-6"">

        <?php

        include('config/snippets/loginForm.php');

        ?>

    </div>

    <?php

    if(!$u->isLoggedIn())
    {
        echo '<div class = "col-md-5 bannerDiv"><img src = "images/banner.png"></div>';
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