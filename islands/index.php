
<?php
require 'lib/site.inc.php';
$view = new Islands\HomeView();
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <?php echo $view->head();?>
</head>
<body>
    <?php echo $view->present(); ?>
</body>
</html>