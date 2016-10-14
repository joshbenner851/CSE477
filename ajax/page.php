<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 4/17/16
 * Time: 10:47 PM
 */

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Language Search</title>
    <script src="jquery.min.js"></script>
    <link rel="stylesheet" href="countries/countries.css">
     <script>
    $(document).ready(function() {
        new Languages("#language_search");
    });
    </script>
</head>
<body>

<form id="language_search">
    <fieldset>
        <p><label for="language">Language</label><br>
            <input type="text" name="language" id="language"></p>
        <p><label for="official">Official</label><br>
            <input type="radio" name="official" value="yes">Yes</input><br>
            <input type="radio" name="official" value="no">No</input><br>
            <input type="radio" name="official" value="neither" checked>Don't Care</input></p>
        <p><input type="submit" value="Search"></p>
    </fieldset>
    <div class="result"></div>
</form>

</body>
</html>