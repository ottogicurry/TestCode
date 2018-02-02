Greetings!  Thanks for checking out my little script.

This is not entirely reflective of how I would actually 
code this, but I wanted to cram in a bit of variety.

index.php
-This is the main front-end script.  It takes input/displays
output too/from the API script.

api/get_team.php
-Returns JSON or gives Error 400 if the input parameters are
incorrecy/not available

classes/team.php
-Most of the logic is happening in here. Even some player logic
that felt like it would come from the 'team manager' is handled
here.

classes/player.php
-This has the logic that I felt the player is responsible for,
such as the name and scores.

tests/TeamTest.php
-PHPUnit tests.  I might have broken  his up to test the player
separately if this exercise got any bigger, but all tests are 
here.

assets directory
-Has jquery and the main css files. I honestly don't usually like
jquery, but for this purpose it fit the bill.  The CSS is very 
generic... I'm just not a designer.

I also flooded all the directories with .htaccess files. Normally,
I would just make all those directories not web-accessible 
structurally instead of relying on .htaccess.

More commentary in the code itself.  I'm commenting more than I
would in a normal environment just to tell more of a story than
simply commenting for future development.