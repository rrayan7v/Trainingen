<?php

class Door {
    private $isLocked = true;  // De deur is standaard op slot
    private $isOpen = false;   // De deur is standaard gesloten
    
    // Methode om de deur te ontgrendelen
    public function unlock() {
        $this->isLocked = false;
    }

    // Methode om de deur weer op slot te doen
    public function lock() {
        $this->isLocked = true;
    }

    // Methode om de deur te openen
    public function open() {
        if ($this->isLocked) {
            return "Deur is nog op slot en kan niet open!"; // De deur is nog op slot en kan niet open
        } else {
            $this->isOpen = true;
            return "Deur is geopend!"; // De deur is geopend
        }
    }

    // Methode om door de deur te lopen
    public function enter() {
        if ($this->isLocked) {
            return "Voordeur is nog op slot!"; // Voordeur is nog op slot, je kunt niet binnen
        } elseif ($this->isOpen) {
            return "Je bent in je huiskamer!"; // Je bent succesvol binnen
        } else {
            return "Je stoot tegen de Voordeur!"; // De deur is dicht, je botst tegen de voordeur
        }
    }
}

# --- Script om de Door-klasse te gebruiken ---
$door = new Door();

// Probeer de deur te ontgrendelen
echo "Deur is ontgrendeld<br>";
$door->unlock(); // Deur ontgrendelen

// Probeer de deur te openen
echo $door->open() . "<br>";

// Probeer door de deur te lopen
echo $door->enter() . "<br>";

?>
