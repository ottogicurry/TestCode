<?php
define('SALARY_CAP', 175);
define('PLAYER_CAP', 100);
define('STARTERS', 10);
define('SUBS', 5);
define('MAX_BALANCE', 10);

require_once('classes/team.php');

use PHPUnit\Framework\TestCase;
 
class TeamTest extends TestCase
{
    public function testSalaryCap() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            
            $total = 0;
            foreach($this->team->players as $player) {
                $total += $player->total_attribute_score;
            }
            $this->assertLessThanOrEqual(SALARY_CAP, $total);
        }
    }
    
    public function testStarterCount() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();

            $total = 0;
            foreach($this->team->players as $player) {
                
                $total += ($player->is_starter) ? 1 : 0;
            }
            $this->assertEquals(10, $total);
        }
    }
    
    public function testSubCount() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            $total = 0;
            foreach($this->team->players as $player) {
                
                $total += ($player->is_starter) ? 0 : 1;
            }
            $this->assertEquals(5, $total);
        }
    }
    
    public function testPlayerCap() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            foreach($this->team->players as $player) {
                $this->assertLessThanOrEqual(100, $player->total_attribute_score);
            }
        }
    }
    
    public function testPlayerName() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            foreach($this->team->players as $player) {
                $this->assertRegExp('/^[A-Z][A-Z0-9]{2,}/', $player->getName());
            }
        }
    }
    
    public function testPlayerSpeed() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            foreach($this->team->players as $player) {
                $this->assertGreaterThan(0, $player->getSpeed());
            }
        }
    }
    
    public function testPlayerStrength() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            foreach($this->team->players as $player) {
                $this->assertGreaterThan(0, $player->getStrength());
            }
        }
    }
    
    public function testPlayerAgility() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            foreach($this->team->players as $player) {
                $this->assertGreaterThan(0, $player->getAgility());
            }
        }
    }
    
    public function testPlayerScoreUniqueness() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            $players = $this->team->players;
            while(0 < count($players)) {
                $player = array_pop($players);
                foreach($players as $player_test_against) {
                    $this->assertNotEquals($player_test_against->total_attribute_score, $player->total_attribute_score);
                }
            }
        }
    }
    
    public function testPlayerNameUniqueness() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            $players = $this->team->players;
            while(0 < count($players)) {
                $player = array_pop($players);
                foreach($players as $player_test_against) {
                    $this->assertNotEquals($player_test_against->getName(), $player->getName());
                }
            }
        }
    }
    
    public function testValidJsonOutput() {
        for($i = 1; $i <=10; $i++) {
            $this->team = new Team;
            $this->team->balance = $i;
            $this->team->create();
            $this->assertNotNull(json_decode($this->team->getJson()));
            $this->assertNotFalse(json_decode($this->team->getJson()));
        }
    }
    
}
?>