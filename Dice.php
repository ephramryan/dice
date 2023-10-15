<?php

class Dice {
    private $numSides;
    private $rollResult;

    public function __construct($numSides = 6) {
        $this->numSides = $numSides;
        $this->rollResult = null; // Initialize rollResult as null
    }

    public function roll() {
        $this->rollResult = rand(1, $this->numSides);
    }

    public function displayInDiv() {
        return "<div class='dice'>" . $this->rollResult . "</div>";
    }
}
