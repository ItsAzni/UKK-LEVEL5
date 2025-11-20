<?php

$connection = mysqli_connect("localhost", "root", "", "ukklv5");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

session_start();

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: auth.php");
        exit();
    }
}

function logout()
{
    session_unset();
    session_destroy();
    header("Location: auth.php");
    exit();
}
