<?php
require_once '../config/init.php';

session_unset();
session_destroy();
header("Location: login.php");
exit;
