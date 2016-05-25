<?php

include('config/config.php');

if(!$u->isLoggedIn()) header('Location: index.php');

else $u->logout();

header('Location: index.php');

