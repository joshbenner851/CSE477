<?php
require 'format.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Win</title>
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
    <figure class="main-pic"><img src="dead-wumpus.jpg" width="600" height="325" alt="A picture of an empty cave"></figure>
    <div class="options">
        <p>You killed the Wumpus</p>
        <p><a href="game.php">New Game</a></p>
    </div>
</div>
</body>
</html>