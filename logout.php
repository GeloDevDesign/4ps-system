<?php

session_unset();
session_destroy();
header("Location: homepagelogin.php");
exit();

