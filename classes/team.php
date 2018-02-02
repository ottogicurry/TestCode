<?php
require_once('player.php');

class Team
{
    public $balance;
    
    /** This is outside of the construct to ensure balance allow balance to be set first
      * We first get the players, then pick the starters, then assign roster spots
      * The latter two could easily be combined given the reqs, but I separated them
      * to use multiple methods.
      */
    public function create() {
        if(false === is_numeric($this->balance)) return false;
        $this->getPlayers();
        $this->assignStarters();
        $this->assignRosterSpots();
    }
    
    private function getPlayers() {
        // We first create player entities and give them numbers, no one is a starter yet
        $this->players = array();
        for($player_number = 1; $player_number <= STARTERS + SUBS; $player_number++) {
            $this->players[$player_number] = new Player();
             $this->players[$player_number]->is_starter = false;  
        }
        
        // We then assigm the Base and Bonus points each player can use
        $this->assignBonusScore($this->assignBaseScore());
        
        // Now each player puts their stats where they want and gets their name
        foreach($this->players as $player_number => $player) {
            $player->splitStats();
            $player->assignNames();
        }
    }

    // Loop through every player assigning the minimal possible points that meet the reqs
    // This is basically ensuring no player has fewer than 3 points, and that no two players
    // have the same number of points.
    private function assignBaseScore() {
        $used_score = 0;
        foreach($this->players as $player_number => $player) {
            $player->base_score = $player_number + 2;
            $used_score += $player_number + 2;
        }
        return $used_score;
    }
    
    
    // Take in the used score and determine how many bonus points to distribute based on the
    // balance selected.  Lower balance equates to being more front loaded on talent.
    private function assignBonusScore($used_score) {
        // setup
        $original_bonus_score = $bonus_score = SALARY_CAP - $used_score;
        
        // Because the players were assigned points low to high, we reverse the array
        // So that higher scoring players get first dibs on bonus points.  This prevents
        // any two players from having the same total attribute score.
        foreach(array_reverse($this->players, true) as $player_number => $player) {
            $player->bonus_score = ceil($bonus_score / ($this->balance * (MAX_BALANCE / 10)));
            if($player->bonus_score == 1) {
                if($player_number == $bonus_score) {
                    $player->bonus_score = 1;
                } else {
                    $player->bonus_score = ceil($bonus_score / $player_number);
                }
            }
            $bonus_score -= $player->bonus_score;
            $player->total_attribute_score = $player->base_score + $player->bonus_score;
        }
        return ($bonus_score == 0);  // Unused return, but would be valuable for debugging
    }
    
    // Could really have handled this in assignBonusScore as you know who the top performers
    // will be. I am just doing this to use some array functions.
    // This will officially assign the starters though.
    private function assignStarters() {
        $starters = array();
        foreach($this->players as $player_number => $player) {
            $starters[$player_number] = $player->total_attribute_score;
            arsort($starters);
            if(count($starters) > 10) {
                array_pop($starters);
            }
        }
        foreach($starters as $player_number => $total_attribute_score) {
            $this->players[$player_number]->is_starter = true;
        }
    }
    
    // More fun with arrays. Again, we really knew the order already.
    // This will officially assign the spot though.
    private function assignRosterSpots() {
        $players = $this->players;
        $this->players = array();
        $highest = 0;
        foreach($players as $player_number => $player) {
            $sortable_arr[$player_number] = $player->total_attribute_score;
        }
        arsort($sortable_arr);
        $i=0;
        foreach($sortable_arr as $player_number => $total_attribute_score) {
            $i++;
            $this->players[$player_number] = $players[$player_number];
            $this->players[$player_number]->roster_spot = $i;
        }
    }
    
    // Rebuilds the array based on roster position instead of player number
    // Then returns the JSON for the viewers' pleasure.
    public function getJson() {
        foreach($this->players as $player_number => $player) {
            $players[$player->roster_spot]['roster_spot'] =  $player->roster_spot;
            $players[$player->roster_spot]['name'] = $player->getName();
            $players[$player->roster_spot]['starter'] = $player->is_starter;
            $players[$player->roster_spot]['speed'] = $player->getSpeed();
            $players[$player->roster_spot]['strength'] = $player->getStrength();
            $players[$player->roster_spot]['agility'] = $player->getAgility();
            $players[$player->roster_spot]['total_attribute_score'] = $player->total_attribute_score;
        }
        return json_encode($players);
    }
    
    
}
//17 to 42