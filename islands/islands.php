<?php
require 'lib/site.inc.php';
$view = new \Islands\GameView($islands);
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <script type="text/javascript" src="jquery-2.2.3.min.js"></script>
    <link href="islands.css" type="text/css" rel="stylesheet" />
    <title>Islands</title>
</head>
<body>
<?php
echo $view->present();
echo $view->presentBoard();
echo $view->toolbar();
?>
</body
</html>