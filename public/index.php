<?php
require_once '../config/init.php';
$username = $_SESSION['username'] ?? null;
echo "Welcome {$username} to the home page!";
