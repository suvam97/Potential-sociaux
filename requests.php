<?php

include('config/config.php');

if (!$u->isLoggedIn()) header('Location: index.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Too light || link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css' -->
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>

    <title><?php if ($u->isLoggedIn()) echo $_SESSION['fName'] . ' ' . $_SESSION['lName']; else echo TITLE; ?> </title>

    <?php

    if (!empty($_POST['btn-accept'])) {

        $acceptedFriend = $_POST['user'];
        if ($u->acceptFriend($acceptedFriend)) {
            header('Location: requests.php');
        }
    }

    if (!empty($_POST['btn-decline'])) {
        $declinedFriend = $_POST['user'];
        if ($u->declineFriend($declinedFriend)) {
            header('Location: requests.php');
        }
    }

    ?>

    <style>

        body
        {
            font-family: 'Abel', sans-serif;
            text-decoration: double;
        }

        .main {
            width: 80%;
            margin: 0 auto;
        }

        .banner {
            border-radius: 10px;
            height: 10%;
            text-align: center;
        }

        #nav {
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

<div class="main">

    <div class="banner">

        <h1 style="padding: 1% 1%;"> My social networking site</h1>
        <hr/>

    </div>

    <div class="content">

        <nav class="navbar navbar-default" id="nav">
            <div class="container-fluid" style="padding: 1%;">
                <ul class="nav nav-pills">
                    <li><a href="index.php">Home</a></li>
                    <?php if ($u->isLoggedIn()) echo '
                    <li><a href="search.php">Search</a></li>

                    <li class = "active"><a href = "requests.php">Friends</a></li>
                    <li><a href = "logout.php">Logout</a></li>
                    ';
                    else echo '<li><a href = "login.php">Login</a></li>';
                    ?>
                </ul>
            </div>

        </nav>

    </div>


    <div class="well col-md-2">
        <h1>My friends</h1>
        <br>
        <hr>
        <ul>
            <?php
            $resultData = $u->getFriends();
            if (!empty($resultData)) {
                foreach ($resultData as $friendInstance) {
                    $one = $friendInstance['sender'];
                    $two = $friendInstance['receiver'];
                    $final = ($one == $_SESSION['user_id']) ? $two : $one;
                    $friendData = $u->getUserByID($final);

                    echo '<li><strong><a href = "profile.php?email=' . $friendData['email'] . '">' . $friendData['fName'] . ' ' . $friendData['lName'] . '</a></strong></li>';
                }
            } else echo '<strong>You have no friends.</strong>'
            ?>
        </ul>
    </div>

    <div class="col-md-5 well" style="margin-left: 2%; margin-right: 2%;">

        <h1>Requests:</h1>
        <br>
        <hr>
        <ul>

            <?php

            $buff = $u->getRequests();
            if (!empty($buff)) {
                foreach ($buff as $request) {
                    $friendDataTwo = $u->getUserByID($request['sender']);
                    echo '<form method = "post" name = "' . $request['sender'] . '">';
                    echo '<li><a href = "profile.php?email=' . $friendDataTwo['email'] . '"><b>' . $friendDataTwo['fName'] . ' ' . $friendDataTwo['lName'] . '</b> has sent you a request.</a>';
                    echo '<input type = "submit" name = "btn-accept" class = "btn btn-success" style="margin-left: 4%; margin-right: 4%;" value="Accept">
                    <input type = "submit"  name = "btn-decline" class = "btn btn-danger" value = "Decline"></li>
                    <input type = "hidden" value = "' . $request['sender'] . '" name = "user">
                    <hr></form>';

                }
            } else echo '<strong>No requests available.</strong>'
            ?>
        </ul>

    </div>

    <div class="well col-md-4">
        <h1>My accepted requests</h1>
        <br>
        <hr>
        <ul>
            <?php
            $r = $u->getRequestHistory();
            if (!empty($r)) {
                foreach ($r as $friendIn) {

                    $friend = $u->getUserByID($friendIn['receiver']);
                    echo '<li>You previously sent <a href = "profile.php?email=' . $friend['email'] . '"><b>' . $friend['fName'] . ' ' . $friend['lName'] . '</b></a> a request.</li>';
                }
            } else echo '<strong>You have sent no requests.</strong>'
            ?>
        </ul>
    </div>

    <div class="col-md-12 footer">
        <br>
        <hr>
        <br>

        <small> <strong>This site is owned by Suvam Mohanty. The rules for usage of this site have been given <a href = "#">here.</a> </strong>

        </small>

    </div>

</div>


</body>
</html>