<?php
require 'format.inc.php';
require 'wumpus.inc.php';


$birds_adjacent = false;
$pits_adjacent = false;
$smell_wampus = false;
$wumpus_room = 16;
$room = 1; // the room we are in
$birds = 7; //Room with the birds
$room_arrow_shot = 0;

$pits = array(3,10,13); // Rooms with a bottomless pit
$cave = cave_array(); //get the cave

if( isset( $_GET['r'] ) && isset( $cave[$_GET['r']] ) ) {
    // We have been passed a room number
    $room = $_GET['r'];
}

if( isset($_GET['a']) && isset($cave[$_GET['a']] ) ) {
    $room_arrow_shot = $_GET['a'];
}

//You shot an arrow into the room with the wumpus
if($room_arrow_shot == $wumpus_room) {
    header("Location: win.php");
    exit;
}


// Are we in a room adjacent to the birds
if( $cave[$room][0] == $birds || $cave[$room][1] == $birds || $cave[$room][2] == $birds ) {
    $birds_adjacent = true;
}

// We're in the room with birds, redirect to rm 10 for now
if( $room == $birds){
    header("Location: game.php?r=10");
    exit;
}

for($i = 0; $i<count($cave[$room]);$i++) {
    if( in_array($cave[$room][$i],$pits))
    {
        $pits_adjacent = true;
        break;
    }
}

// Are we in a pit so we lost
if( in_array($room,$pits)){
    header("Location: lose.php");
    exit;
}

// Are we in the room with the wumpus
if($room == $wumpus_room) {
    header("Location: lose.php");
    exit;
}

// Check if one room away from the Wumpus
if( $cave[$room][0] == $wumpus_room || $cave[$room][1] == $wumpus_room || $cave[$room][2] == $wumpus_room) {
    $smell_wampus = true;
}
// Check if we're two rooms away from the Wumpus
else {
    //for all this rooms adjacent rooms
    for( $i = 0; $i<count($cave[$room]); $i++) {
        if( in_array($wumpus_room,$cave[$cave[$room][$i]])) {
            $smell_wampus = true;
            break;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Game</title>
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
        <div class="content">
            <figure class="main-pic"><img src="cave.jpg" width="600" height="325" alt="A picture of an empty cave"></figure>
            <div class="rooms">
                <div class="outcome">
                <p class="room-num">You are in room <?php echo $room; ?></p>
                <p> &nbsp;<?php if($birds_adjacent){ echo "You hear the birds!";} ?></p>
                <p> &nbsp;<?php if( $pits_adjacent ){ echo "You feel a draft!";} ?></p>
                <p class="wumpus"> &nbsp;<?php if($smell_wampus) echo "You smell a wumpus!"?></p>
                </div>
                <div class="room">
                    <figure><img src="cave2.jpg" alt="Empty cave photo"></figure>
                    <p><a href="game.php?r=<?php echo $cave[$room][0]; ?>"><?php echo $cave[$room][0]; ?></a></p>
                    <p><a href="game.php?r=<?php echo $room . "&a=" . $cave[$room][0]?>">Shoot Arrow</a></p>
                </div><div class="room">
                    <figure><img src="cave2.jpg" alt="Empty cave photo"></figure>
                    <p><a href="game.php?r=<?php echo $cave[$room][1]; ?>"><?php echo $cave[$room][1]; ?></a></p>
                    <p><a href="game.php?r=<?php echo $room . "&a=" . $cave[$room][1]?>">Shoot Arrow</a></p>
                </div><div class="room">
                    <figure><img src="cave2.jpg" alt="Empty cave photo"></figure>
                    <p><a href="game.php?r=<?php echo $cave[$room][2]; ?>"><?php echo $cave[$room][2]; ?></a></p>
                    <p><a href="game.php?r=<?php echo $room . "&a=" . $cave[$room][2]?>">Shoot Arrow</a></p>
                </div>
                <p class="outcome arrows">You have 3 arrows remaining.</p>
            </div>
        </div>
    </body>
</html>