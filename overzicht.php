<?php
// overzicht.php

declare(strict_types=1);

require_once 'BestellingenLijst.php';

$bestellingenLijst = new BestellingenLijst();
$bestellingen = $bestellingenLijst->getBestellingen();
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/png" href="sandwich.png">
  <title>Overzicht Bestellingen</title>
</head>

<body>
  <h1>Overzicht Bestellingen</h1>
  <table>
    <thead>
      <tr>
        <th>Gebruiker</th>
        <th>Broodje</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bestellingen as $bestelling) { ?>
        <tr>
          <td>
            <?php echo $bestelling->getGebruiker()->getNaam(); ?>
          </td>
          <td>
            <?php echo $bestelling->getBroodje()->getNaam(); ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
      <ul class="custom-list">
        <li><a href="bestel.php">Terug naar Bestel pagina</a></li> 
        <li><a href="index.php">Terug naar Startpagina</a></li>
      </ul>


  </p>

</body>

</html>