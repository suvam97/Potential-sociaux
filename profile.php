<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Too light || link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css' -->
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>

<?php

include('config/config.php');

if(!$u->isLoggedIn()) header('Location: index.php');


$email = $_GET['email'];
if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    header('404.php');
}

if( ($data = $u->getUser($email)) != null)
{
    // Now $data contains the data of the requested user.
    $path = 'images/'.$data['user_id'].'png';
    if(!file_exists($path)) $path = 'images/generic.png';

    echo '<title>';
    if($u->isLoggedIn()) echo $data['fName'].' '.$data['lName'];
    else echo TITLE;
    echo '

    </title>';

}

if(isset($_POST['btn-add-friend'])) {
    $status = $u->isRelatedTo($data['user_id']);
    if($status == 0 && ($_POST['stats'] == 0)) // not friends
    {
        // send a request now
        $u->sendRequest($data['user_id']);
        header('Refresh: 0');
    }

    if(($_POST['stats'] == 2))
    {
        $u->deleteFriend($data['user_id']);
        header('Refresh: 0');
    }
}

?>

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

    .desc
    {
        font-weight: 500;
        font-size: larger;
    }


    .footer
    {
        width: 100%;
        font-family: 'Poiret One', cursive;
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
                    <li class="active"><a href="search.php">Search</a></li>

                    <li><a href = "requests.php">Friends</a></li>
                    <li><a href = "logout.php">Logout</a></li>
                    ';
                    else echo '<li><a href = "login.php">Login</a></li>';
                    ?>
                </ul>
            </div>

        </nav>

    </div>


        <div class = "well col-md-2">
            <?php

            $ext = array('.png', '.jpg', '.gif');

            $path = 'images/'.$data['user_id'];
            for($i = 0; $i < 3; $i++) {
                if (file_exists($path . $ext[$i]))
                {
                    $path = $path.$ext[$i];
                    break;
                }
                else if($i == 2) $path = 'images/generic.png';
            }



                echo '

                <img src="'.$path.'" alt="'.$data['fName'].' '.$data['lName'].'" class="img-thumbnail" style = "width: 140px; height: 140px;">
                <br><br>';

                echo '<h3>'.$data['fName'].' '.$data['lName'].'</h3>';

                echo '<br><br>';
                $status = $u->isRelatedTo($data['user_id']);
                if($data['user_id'] == $_SESSION['user_id']) $status = 4;


                switch($status)
                {
                    case 0: $desc = "Add friend"; break;
                    case 1: $desc = "Friendship in progress"; break;
                    case 2: $desc = "Unfriend"; break;
                    default: $desc = "Me";
                }

                echo '

                    <form method ="post">
                    <input type = "hidden" name = "stats" value = "'.$status.'">
                    <input type = "submit" style = "margin-left: 5%" name = "btn-add-friend" value = "'.$desc.'" class = "btn btn-primary '; if($status == 1 || $status == 4) echo 'disabled">'; else echo '">
                    </form>
                    ';

            ?>
        </div>

        <div class="col-md-5 well desc" style="margin-left: 2%;">
            <br>
            <?php

                if($u->isFriendOf($data['user_id'])) {

                    echo '<b>Name:</b> ' . $data['fName'] . ' ' . $data['lName'] . '<br><br>';
                    $date = strtotime($data['bDate']);
                    echo '<b>Birthdate:</b> ' . date("Y, j M", $date) . '<br><br>';
                    echo '<b>Email: </b>' . $data['email'] . '<br><br>';
                }
                else if($desc == "Me")
                {
                    echo '<b>Hello, myself.';
                }


                else
                {

                    echo 'This user is <b>NOT</b> a friend of yours.<br>';
                    echo 'Send a friend request to access this profile.';
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

