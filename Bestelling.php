<?php
// Bestelling.php

declare(strict_types=1);

class Bestelling {
    private int $id;
    private Broodje $broodje;
    private Gebruiker $gebruiker;

    public function __construct(int $id, Broodje $broodje, Gebruiker $gebruiker) {
        $this->id = $id;
        $this->broodje = $broodje;
        $this->gebruiker = $gebruiker;
    }

    public function getID(): int {
        return $this->id;
    }

    public function getBroodje(): Broodje {
        return $this->broodje;
    }

    public function getGebruiker(): Gebruiker {
        return $this->gebruiker;
    }
}
?>
