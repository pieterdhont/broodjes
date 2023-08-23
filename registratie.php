<?php
// registratie.php

declare(strict_types=1);
require_once 'GebruikersLijst.php';

session_start();

$message = "";

if (isset($_SESSION["userID"])) {
    $message = "Registratie is niet mogelijk terwijl u ingelogd bent.";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];
    $herhaalWachtwoord = $_POST["herhaalWachtwoord"];

    $validations = [
        ['condition' => empty($naam) || empty($email) || empty($wachtwoord) || empty($herhaalWachtwoord), 'message' => "Alle velden zijn verplicht."],
        ['condition' => !filter_var($email, FILTER_VALIDATE_EMAIL), 'message' => "Ongeldig e-mailadres."],
        ['condition' => $wachtwoord !== $herhaalWachtwoord, 'message' => "Wachtwoorden komen niet overeen."]
    ];

    foreach ($validations as $validation) {
        if ($validation['condition']) {
            $message = $validation['message'];
            break;
        }
    }

    if (empty($message)) {
        $message = GebruikersLijst::registreren($naam, $email, $wachtwoord, $herhaalWachtwoord);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="sandwich.png">
    <title>Registratie</title>
</head>

<body>
    <h1>Registreren</h1>
    <form method="post" action="" class="vertical-form"<?php if (isset($_SESSION["userID"])) {
        echo 'style="display:none;"';
    } ?>>
        <label for="naam">Naam:</label>
        <input type="text" name="naam" required>
        <label for="email">E-mail:</label>
        <input type="email" name="email" required>
        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" required>
        <label for="herhaalWachtwoord">Herhaal wachtwoord:</label>
        <input type="password" name="herhaalWachtwoord" required>
        <input type="submit" value="Registreren">
    </form>
    <p style="color:red;">
        <?php echo $message; ?>
    </p>
    <?php if ($message === "Registratie succesvol!"): ?>
        <p><a href="inloggen.php">Ga naar de inlogpagina</a></p>
    <?php endif; ?>
    
    <ul class="custom-list">
        <li><a href="index.php">Terug naar de Startpagina</a></li>
        <li><a href="uitloggen.php">Log uit</a></li>
    </ul>

</body>

</html>