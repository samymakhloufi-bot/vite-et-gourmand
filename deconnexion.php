<?php 
require_once './login.php';
session_destroy();
setcookie('remember_token', '', time() - 3600, '/');

header('Location: index.php');
exit();