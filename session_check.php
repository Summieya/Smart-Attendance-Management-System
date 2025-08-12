<?php
session_start();


$timeout_duration = 900;

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['start_time']) && (time() - $_SESSION['start_time']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php?session_expired=1");
    exit;
} else {
    $_SESSION['start_time'] = time(); // Reset timer on activity
}
?>
