<?php
// inloggen.php

declare(strict_types=1);

require_once 'GebruikersLijst.php';


session_start();


if (isset($_SESSION["userID"])) {
    $message = "U bent al ingelogd.";
} else {
    $message = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $wachtwoord = $_POST["wachtwoord"];
        if (GebruikersLijst::isUserBlocked($email)) {
            $message = "Uw account is geblokkeerd.";
        } else {
            $gebruiker = GebruikersLijst::inloggen($email, $wachtwoord);
            if ($gebruiker) {
                setcookie("email", $email, time() + (86400 * 30), "/");
                $_SESSION["userID"] = $gebruiker->getId();
                header("Location: bestel.php");
                exit;
            } else {
                $message = "Ongeldige e-mail of wachtwoord.";
            }
        }
    } elseif (isset($_GET["error"]) && $_GET["error"] === "notloggedin") {
        $message = "U moet eerst inloggen om toegang te krijgen tot de bestelpagina.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="sandwich.png">
    <title>Inloggen</title>
</head>

<body>
    <h1>Inloggen</h1>
    <form method="post" action="" class="vertical-form"<?php if (isset($_SESSION["userID"])) {
        echo 'style="display:none;"';
    } ?>>
        <label for="email">E-mail:</label>
        <input type="email" name="email" value="<?php if (isset($_COOKIE["email"])) {
            echo $_COOKIE["email"];
        } ?>"
            required>
        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" required>
        <input type="submit" value="Inloggen">
    </form>
    <p style="color:red;">
        <?php echo $message; ?>
    </p>
    <ul class="custom-list">
        <li><a href="bestel.php">Bestel</a></li>
        <li><a href="index.php">Terug naar de Startpagina</a></li>
        <li><a href="uitloggen.php">Log uit</a></li>
    </ul>

</body>

</html>