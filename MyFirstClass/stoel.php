<?php
class Stoel {
    private $kleur;
    private $zithoogte;

    public function __construct($kleur, $zithoogte) {
        $this->kleur = $kleur;
        $this->zithoogte = $zithoogte;
    }

    public function getKleur() {
        return $this->kleur;
    }

    public function getZithoogte() {
        return $this->zithoogte;
    }

    public function verstelZithoogte($nieuweHoogte) {
        $this->zithoogte = $nieuweHoogte;
    }
}
?>
