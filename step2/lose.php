<?php
require 'format.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lose</title>
    <link href="main.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php
/**
 * Create the HTML for the header block
 * @param $title The page title
 * @return string HTML for the header block
 */
echo present_header("Stalking the Wumpus");
?>
    <div class="content">
        <figure class="main-pic"><img src="wumpus-wins.jpg" width="600" height="325" alt="Cat with a brain in it's mouth"></figure>
        <div class="options">
            <p>You died and the Wumpus ate your brain!</p>
            <p><a href="game.php">New Game</a></p>
        </div>
    </div>
</body>
</html>