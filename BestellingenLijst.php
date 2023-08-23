<?php
// BestellingenLijst.php

declare(strict_types=1);
require_once 'Database.php';
require_once 'Bestelling.php';
require_once 'Broodje.php';
require_once 'Gebruiker.php';

class BestellingenLijst {
    
    public static function bestelBroodje(int $broodjeId, int $gebruikerId): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO bestellingen (broodje_id, gebruiker_id) VALUES (:broodje_id, :gebruiker_id)");
        $stmt->execute([
            ':broodje_id' => $broodjeId,
            ':gebruiker_id' => $gebruikerId
        ]);
    }

    public static function getBestellingen(): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT b.id, b.broodje_id, b.gebruiker_id, br.Naam as broodjeNaam, br.Omschrijving, br.Prijs as broodjePrijs, g.naam as gebruikerNaam
                              FROM bestellingen b 
                              JOIN broodjes br ON b.broodje_id = br.ID 
                              JOIN gebruikers g ON b.gebruiker_id = g.id");
        $stmt->execute();
        
        $bestellingen = [];
        while ($row = $stmt->fetch()) {
            $broodje = new Broodje(
                (int)$row['broodje_id'],
                $row['broodjeNaam'],
                $row['Omschrijving'],
                (float)$row['broodjePrijs']
            );
            $gebruiker = new Gebruiker((int)$row['gebruiker_id'], $row['gebruikerNaam'], "");
            $bestelling = new Bestelling((int)$row['id'], $broodje, $gebruiker);
            $bestellingen[] = $bestelling;
        }
        return $bestellingen;
    }
}
?>
