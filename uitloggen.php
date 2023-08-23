<?php
// uitloggen.php

declare(strict_types=1);

session_start();


if (!isset($_SESSION["userID"])) {
    header("Location: index.php");
    exit();
}


session_destroy();


setcookie("email", "", time() - 3600, "/");
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="sandwich.png">
    <title>Uitloggen</title>
</head>

<body>
    <h1>Uitloggen</h1>
    <p>U bent uitgelogd.</p>
    <ul class="custom-list">
        <li><a href="index.php">Terug naar Startpagina</a></li>
    </ul>

</html>