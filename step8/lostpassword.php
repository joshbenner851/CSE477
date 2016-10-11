<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 7:01 AM
 */
require 'lib/site.inc.php';
$view = new Felis\LostPasswordView($site, $_GET, $_SESSION);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $view->head(); ?>
</head>

<body>
<div class="user">
<?php
    echo $view->header();
    echo $view->present();
    echo $view->footer();
?>

</div>

</body>
</html>