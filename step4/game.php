<?php
    require 'format.inc.php';
    require 'lib/game.inc.php';
    $view = new Wumpus\WumpusView($wumpus);

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
                    <?php
                    echo $view->presentStatus()
                    ?>
                </div>
                <div class="rooms">
                    <?php
                    echo $view->presentRoom(0);
                    echo $view->presentRoom(1);
                    echo $view->presentRoom(2);
                    ?>
                </div>
                <?php
                    echo $view->presentArrows()
                ?>
            </div>
        </div>
    </body>
</html>