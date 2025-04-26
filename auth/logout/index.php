<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['phone']);
unset($_SESSION['email']);
unset($_SESSION['role']);
unset($_SESSION['is_logged_in']);
session_destroy();
header("location: /");

?>