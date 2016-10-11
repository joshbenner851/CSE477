<?php
require 'format.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instructions</title>
    <link href="main.css" type="text/css" rel="stylesheet"/>
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
    <div class="instructions">
        <figure class="main-pic"><img src="cave-evil-cat.png" width="600" height="325" alt="A picture of an empty cave"></figure>
        <p>In this game you are hunting the evil, killer Wumpus. This is a Wumpus.
            Yes, it looks like a cat, but that's only a disguise he uses on the Internet.
            The Wumpus lives in a cave. The cave has rooms that are interconnected by tunnels.
            Each room connects to three other rooms. The Wumpus is in one of those rooms.
            You are in another room. You move from room to room.
            If you enter the room with the Wumpus, it claws your eyes out, eats your brain, and you die.</p><br>
        <p>The goal of the game is to shoot the Wumpus with a magic arrow before it eats you or you otherwise meet your maker in this dangerous cave.
            But, be careful. You only have 3 arrows. When they are gone, you and you brain are defenseless. You shoot an arrow into a room.
            It will bounce on to one other room randomly. If you kill the Wumpus, you win!</p><br>
        <p>The cave has bottomless pits and very strong, unladen swallows. If you move into a room with a bottomless pit,
            you fall in and die. If you move into a room with the swallows, they pick you up and drop you in some other room.
            They may drop you in a room with a Wumpus or a bottomless pit, which will positively ruin you day.</p><br>
        <p>If you are in a room adjacent to a bottomless pit, you will feel a draft. If you are in a room adjacent
            to the flock of swallows, you will hear birds. The Wumpus smells particularly bad,
            so if you are within two rooms of the Wumpus, you will smell him.</p><br>
        <p>The rooms are connected by tunnels. To move to another room, click on the image for that room.
            To shoot an arrow into an adjacent room, click on Shoot Arrow below that room.</p><br>
        <p>Have Fun!</p>
        <div class="options">
            <p><a href="game.php">Return to Game</a></p>
            <p><a href="game-post.php?n">New Game</a></p>
        </div>
    </div>
</body>

</html>