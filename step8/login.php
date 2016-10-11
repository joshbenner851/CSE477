<?php
$open = true;
require 'lib/site.inc.php';
$view = new Felis\LoginView($_SESSION, $_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Felis Investigations Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="lib/css/felis.css">
</head>

<body>

    <div class="login">
        <?php echo $view->header(); ?>
        <?php echo $view->displayError(); ?>
    <!--<nav>-->
    <!--	<ul class="left">-->
    <!--		<li><a href="./">The Felis Agency</a></li>-->
    <!--	</ul>-->
    <!--</nav>-->
    <!---->
    <!--<header class="main">-->
    <!--	<h1><img src="images/comfortable.png" alt="Felis Mascot"> Felis Investigations <img src="images/comfortable.png" alt="Felis Mascot"></h1>-->
    <!--</header>-->

    <form method="post" action="post/login.php">
        <fieldset>
            <legend>Login</legend>
            <p>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email">
            </p>
            <p>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Password">
            </p>
            <p>
                <input type="submit" value="Log in"> <a href="lostpassword.php">Lost Password</a>
            </p>
            <p><a href="./">Felis Agency Home</a></p>

        </fieldset>
    </form>

        <?php echo $view->footer(); ?>

    </div>

</body>
</html>
