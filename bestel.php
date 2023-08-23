<?php
// Bestel.php

declare(strict_types=1);

require_once 'BroodjesLijst.php';
require_once 'BestellingenLijst.php';
require_once 'GebruikersLijst.php';

session_start();

// Check if user is not logged in
if (!isset($_SESSION["userID"])) {
  header("Location: inloggen.php?error=notloggedin"); // Redirect to login page
  exit();
}

$gebruikerId = $_SESSION["userID"];
$loggedInUser = GebruikersLijst::getGebruikerById($gebruikerId);
$gebruikerNaam = $loggedInUser ? $loggedInUser->getNaam() : "Onbekende gebruiker";

$baseUrl = basename($_SERVER['PHP_SELF']);
$message = "";

if (isset($_GET["action"]) && $_GET["action"] === "bestel") {
  $broodjeId = (int) $_POST["broodje"];
  BestellingenLijst::bestelBroodje($broodjeId, $gebruikerId);
  header("location:{$baseUrl}?status=success");
  exit;
} else if (isset($_GET["status"]) && $_GET["status"] === "success") {
  $timestamp = date("H:i:s");
  $message = "Broodje is besteld om $timestamp!";
}

$broodjesLijst = new BroodjesLijst();
$broodjes = $broodjesLijst->getBroodjes();
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/png" href="sandwich.png">
  <title>Bestel een Broodje</title>
</head>


<body>
  <h1>Bestel een Broodje</h1>
  <p>Ingelogd als: <strong>
      <?php echo $gebruikerNaam; ?>
    </strong>
  <form method="post" action="<?php echo $baseUrl; ?>?action=bestel">
    <select name="broodje">
      <?php foreach ($broodjes as $broodje) { ?>
        <option value="<?php echo $broodje->getID(); ?>">
          <?php echo $broodje->getNaam(); ?>
          -----
          <?php echo $broodje->getOmschrijving(); ?>
          - €
          <?php echo $broodje->getPrijs(); ?>
        </option>

      <?php } ?>
    </select>
    <input type="submit" value="Bestel">
  </form>
  <p style="color:blue" ;>
    <?php echo $message; ?>
  </p>
  <ul class="custom-list">
    <li><a href="overzicht.php">Overzicht Bestellingen</a></li>
    <li><a href="index.php">Terug naar Startpagina</a></li>
    <li><a href="uitloggen.php">Uitloggen</a></li>
  </ul>

</body>

</html>