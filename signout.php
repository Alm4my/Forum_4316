<?php
session_start();
session_unset();
unset($_SESSION['user_name']);
header("Location: index.php");