<?php
// GebruikersLijst.php

declare(strict_types=1);

require_once 'Database.php';
require_once 'Gebruiker.php';

class GebruikersLijst {

    public static function registreren(string $naam, string $email, string $wachtwoord, string $herhaalWachtwoord): string {
        if ($wachtwoord !== $herhaalWachtwoord) {
            return "Wachtwoorden komen niet overeen.";
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM gebruikers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $gebruiker = $stmt->fetch();

        if ($gebruiker) {
            return "E-mailadres is al geregistreerd.";
        }

        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO gebruikers (naam, email, wachtwoord) VALUES (:naam, :email, :wachtwoord)");
        $stmt->execute(['naam' => $naam, 'email' => $email, 'wachtwoord' => $hashedPassword]);

        return "Registratie succesvol!";
    }

    public static function inloggen(string $email, string $wachtwoord): ?Gebruiker {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM gebruikers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $gebruiker = $stmt->fetch();

        if ($gebruiker && password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
            return new Gebruiker((int)$gebruiker['id'], $gebruiker['naam'], $gebruiker['email']);
        }

        return null;
    }

    public static function getGebruikerById(int $id): ?Gebruiker {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM gebruikers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $gebruiker = $stmt->fetch();

        if ($gebruiker) {
            return new Gebruiker((int)$gebruiker['id'], $gebruiker['naam'], $gebruiker['email']);
        }

        return null;
    }
}
?>
