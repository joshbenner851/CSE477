<?php
$open = true;
require 'lib/site.inc.php';
$view = new Noir\View($site, $_GET, $_SESSION);
$view->setTitle("Film Noir Login");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $view->head(); ?>
</head>
<body>
<?php
echo $view->header();
?>

<form class="login" method="post" action="post/login.php">
	<fieldset>
		<p><label for="user">User ID: </label>
			<input type="text" id="user" name="user"></p>
		<p><label for="password">Password: </label>
			<input type="password" id="password" name="password"></p>
		<p>Please log in with your CSE user ID and your MySQL database password.</p>
		<p class="buttons"><input type="submit" name="ok" value="Login">
		</p>
		<p>This site will create a new table in your MySQL database named filenoir_movie.
		Be sure you are okay with that prior to logging in.</p>

	</fieldset>
</form>

<?php
if(isset($_GET['e'])) {
	echo '<p class="error">Unable to log in. Be sure you are using the database password.</p>';
}
?>

<?php
//echo $view->present();
echo $view->footer();
?>

</body>
</html>