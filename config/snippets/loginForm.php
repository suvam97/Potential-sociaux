<?php

echo '

<h2>Login into your account:</h2>

<br> <br>

<form class="form-horizontal" method="post">

    ';

if(isset($empty)) echo '<div class="alert alert-danger" style = "width: 40%;" role="alert">'. $empty . '</div><br>';

echo '
    <br>

    <div class="form-group">
        <label for="inputEmailLogin" class="col-sm-2 control-label">Email: </label>
        <div class="col-sm-4">
            <input type="email" class="form-control" name="inputEmailLogin" placeholder="Email">
        </div>
    </div>

    <div class="form-group">
        <label for="inputPasswordLogin" class="col-sm-2 control-label">Password: </label>
        <div class="col-sm-4">
            <input type="password" class="form-control" name="inputPasswordLogin" placeholder="Password">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-1">
            <br><br>
            <button type="submit" name = "btn-submit-login" class="btn btn-success">Login</button>
        </div>
    </div>

</form>

';
