<?php
// Gebruiker.php
declare(strict_types=1);

class Gebruiker {
    private int $id;
    private string $naam;
    private string $email;

    public function __construct(int $id, string $naam, string $email) {
        $this->id = $id;
        $this->naam = $naam;
        $this->email = $email;
    }

    public function getID(): int {
        return $this->id;
    }

    public function getNaam(): string {
        return $this->naam;
    }

    public function getEmail(): string {
        return $this->email;
    }
}
?>

