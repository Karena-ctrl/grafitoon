<?php
session_start();
session_unset();
session_destroy();
header("Location: Grafitoon_login.php");
exit();
