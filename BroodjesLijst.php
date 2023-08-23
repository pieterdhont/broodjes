<?php
// BroodjesLijst.php
declare(strict_types=1);
require_once 'Database.php';
require_once 'Broodje.php';

class BroodjesLijst {

    public function getBroodjes(): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT ID, Naam, Omschrijving, Prijs FROM broodjes");
        $stmt->execute();
        
        $broodjes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $broodje = new Broodje((int)$row['ID'], $row['Naam'], $row['Omschrijving'], (float)$row['Prijs']);
            $broodjes[] = $broodje;
        }
        return $broodjes;
    }
}
?>

