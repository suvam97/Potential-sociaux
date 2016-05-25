<?php

$name = $_SESSION['fName'].' '.$_SESSION['lName']. ' (Me)';

echo '

<div class = "row">

<div class = "col-md-6 well" style="padding-left: 7%;">
<h2>'.$name.'</h2>

<br>

<form class="form-horizontal" method="post" action = "upload.php"  enctype="multipart/form-data">

    ';
    $ext = array('.png', '.jpg', '.gif');

    $path = 'images/'.$_SESSION['user_id'];
    for($i = 0; $i < 3; $i++) {
        if (file_exists($path . $ext[$i]))
        {
            $path = $path.$ext[$i];
            break;
        }
        else if($i == 2) $path = 'images/generic.png';
    }

    ?>

    <img src="<?php echo $path ?>" alt="<?php echo $name ?>" class="img-thumbnail" style = "width: 140px; height: 140px;">
    <br><br>

<?php $empty = "AY"; ?>

    <span class="btn btn-default btn-file">
        Browse <input type="file" name="fileToUpload" id="fileToUpload">
    </span>
    <button type = "submit" class = "btn btn-primary">Make DP</button>

    <br>
    <br>

    (Browse and select a .png, .gif or a .img file and <br>press <strong><i>Make DP</i></strong> to successfully upload it.


    </form>

    </div>

    <div class = "col-md-4 well" style = "margin-left: 5%;">


    <br>

    <?php echo '
    <b>Name:</b> '.$_SESSION['fName'].' '.$_SESSION['lName'].'<br><br>';
    $date = strtotime($_SESSION['bDate']);
    echo '<b>Birthdate:</b> '.date("Y, j M", $date).'<br><br>';
    echo '<b>Email: </b>'.$_SESSION['email'].'<br><br>';
    ?>

</div>

</div>

