<?php

echo '

<h2>Register an account below:</h2>

<br> <br>

<form class="form-horizontal" method="post">

    ';

    if(isset($empty)) echo '<div class="alert alert-danger" style = "width: 40%;" role="alert">'. $empty . '</div><br>';

    echo '
    <br>
    <div class="form-group">
        <label for="inputfName" class="col-sm-2 control-label">First name: </label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="inputfName" placeholder="First name">
        </div>

    </div>

    <div class="form-group">
        <label for="inputlName" class="col-sm-2 control-label">Last Name: </label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="inputlName" placeholder="Last name">
        </div>
    </div>

    <div class="form-group">
        <label for="inputDate" class="col-sm-2 control-label">Date of birth: </label>
        <div class="col-sm-4">
            <input type="date" class="form-control" name="inputDate" placeholder="">
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmail" class="col-sm-2 control-label">Email: </label>
        <div class="col-sm-4">
            <input type="email" class="form-control" name="inputEmail" placeholder="Email">
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword" class="col-sm-2 control-label">Password: </label>
        <div class="col-sm-4">
            <input type="password" class="form-control" name="inputPassword" placeholder="Password">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-1">
            <br><br>
            <button type="submit" name = "btn-submit-register" class="btn btn-success">Register</button>
        </div>
    </div>

</form>

';
