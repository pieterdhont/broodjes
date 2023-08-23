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
            if ($gebruiker['is_blocked'] == 1) {
                return null;  
            }
            return new Gebruiker((int)$gebruiker['id'], $gebruiker['naam'], $gebruiker['email'], (bool)$gebruiker['is_blocked']);
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

    public static function blockUser(int $userId): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE gebruikers SET is_blocked = 1 WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public static function unblockUser(int $userId): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE gebruikers SET is_blocked = 0 WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public static function isUserBlocked(string $email): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT is_blocked FROM gebruikers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        
        if ($result && $result['is_blocked'] == 1) {
            return true;
        }
        return false;
    }

    public static function getAllUsers(): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM gebruikers");
        $stmt->execute();
        $users = [];
        while ($row = $stmt->fetch()) {
            $users[] = new Gebruiker((int)$row['id'], $row['naam'], $row['email'], (bool)$row['is_blocked']);
        }
        return $users;
    }
}
?>
