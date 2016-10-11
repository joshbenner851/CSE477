<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/1/16
 * Time: 12:47 AM
 */
$open = true;
require 'lib/site.inc.php';
$view = new Felis\PasswordValidateView($site, $_GET, $_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
</head>

<body>
<div class="user">

<!-- Create the body HTML here -->

<?php
echo $view->header();
echo $view->present();
echo $view->footer();
?>

</div>

</body>
</html>