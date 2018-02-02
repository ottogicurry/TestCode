<?php
require_once('traits/generator.php');

class Player { 
    use NameGenerator;

    // Variable are public or private based on who I thought best
    // controlled their values.  Coach/league assigned vs born with it.
    public $base_score;
    public $is_starter;
    public $bonus_score;
    public $total_attribute_score;  // Just a sum of base and bonus score
    public $roster_spot; // Not a requirement, but helpful visually
    private $speed;
    private $strength;
    private $agility;
    private $name;
    
    // Splits the assigned stats into the three different categories randomly
    public function splitStats() {
        // Need a minimum of 1 point in each, so getting that out of the way
        $this->speed = 1;
        $this->strength = 1;
        $this->agility = 1;
        $remaining_score = $this->total_attribute_score - 3; 
        
        // Loop until no points left to assign.  This is potentially dangerous
        // but lines 30 and 41 are not wrapped in any condition.
        while($remaining_score > 0) {
            $assign_score = rand(1,$remaining_score);
            switch(rand(1,3)) {
                case 1: 
                    $this->speed += $assign_score;
                    break;
                case 2:
                    $this->strength += $assign_score;
                    break;
                default:
                    $this->agility += $assign_score;
            }
            $remaining_score -= $assign_score;
        }
    }
    
    /** We use the little Trait here.  No that we really need a Trait, but the
      * functionality was a good reason to use it. Since precautions were taken
      * to ensure the stats are unique, we use them to make a tiny name hash
      */
    public function assignNames() {
        $this->name='';
        $this->name .= $this->getLetters($this->speed);
        $this->name .= $this->getLetters($this->strength);
        $this->name .= $this->agility;
    }
    
    
    // For viewing of private variables
    public function getSpeed() {
        return $this->speed;
    }
    
    public function getStrength() {
        return $this->strength;
    }
    
    public function getAgility() {
        return $this->agility;
    }
    
    public function getName() {
        return $this->name;
    }
}