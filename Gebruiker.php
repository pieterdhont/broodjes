<?php
// Gebruiker.php

declare(strict_types=1);

class Gebruiker {
    private int $id;
    private string $naam;
    private string $email;
    private bool $isBlocked;

    public function __construct(int $id, string $naam, string $email, bool $isBlocked = false) {
        $this->id = $id;
        $this->naam = $naam;
        $this->email = $email;
        $this->isBlocked = $isBlocked;
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

    public function isBlocked(): bool {
        return $this->isBlocked;
    }
}
?>
