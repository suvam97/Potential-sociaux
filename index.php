<?php

include_once('config/config.php');

if(isset($_POST['btn-submit-register']))
{
    if(empty($_POST['inputfName']) || empty($_POST['inputlName']) || empty($_POST['inputDate']) || empty($_POST['inputEmail']) || empty($_POST['inputPassword'])) $empty = "Please complete ALL the fields.";
    else
    {
        $name = array(
            'first' => $_POST['inputfName'],
            'last' => $_POST['inputlName']
        );

        if($u->register($name, $_POST['inputEmail'], $_POST['inputPassword'], $_POST['inputDate']) != -1)
        {
           if($u->login($_POST['inputEmail'], $_POST['inputPassword']))
           {
               header('Refresh: 0');
           }
        }

        else $empty = "This email seems to have been taken already.";
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

        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
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
                    <li class="active"><a href="#">Home</a></li>
                    <?php if($u->isLoggedIn()) echo '
                    <li><a href="search.php">Search</a></li>
                    <li><a href = "requests.php">Friends</a></li>
                    <li><a href = "logout.php">Logout</a></li>
                    ';
                    else echo '<li><a href = "login.php">Login</a></li>';
                    ?>
                </ul>
            </div>

        </nav>

           <div class = "col-md-6">

                <?php

                if(!$u->isLoggedIn())
                    include('config/snippets/registerForm.php');
                else
                   include('config/snippets/uploadProfilePic.php');

                ?>

            </div>

            <?php

            if(!$u->isLoggedIn())
            {
                echo '<div class = "col-md-5 bannerDiv"><img src = "images/banner2.jpg"></div>';
            }

            ?>


    </div>

    <div class = "col-md-12 footer">
        <br>
        <hr>
        <br>

        <small><strong>This site is owned by Suvam Mohanty. The rules for usage of this site have been given <a href = "#">here.</a></strong></small>
    </div>



    </div>



    </body>


</html>