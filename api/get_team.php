<?
// Unchanging parameters being set as constants
define('SALARY_CAP', 175);
define('STARTERS', 10);
define('SUBS', 5);

// Max balance is used for a balance parameter input
define('MAX_BALANCE', 10);

/** Checking the "balance" input.  It is required to build
  * a team.  Treating it like a weekly draft fantasy sports
  * league, more balance gets more average players, while
  * less balance top loads the roster.  If the balance is 
  * not provided, we'll return a 400 error.
  *
  * Worth noting, right-side variables are good practice
  * to save time debugging accidental overrides.  I'm not
  * married to it, but I feel it's a good habit.
***/  
if( false === isset($_GET['balance']) || 
    false === is_numeric($_GET['balance']) ||
    MAX_BALANCE < $_GET['balance'] ||
    1 > $_GET['balance'] ) {
        http_response_code(400);
        die();
}

// Putting this here since we won't need it until now
// On a larger project, I group requires with other
// setup at the top.
require_once('../classes/team.php');

// Setting up the team, hopefully explains itself
$team = new Team();
$team->balance = $_GET['balance'];
$team->create();
echo $team->getJson();

