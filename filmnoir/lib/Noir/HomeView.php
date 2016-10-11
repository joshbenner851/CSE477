<?php
/**
 * Created by PhpStorm.
 * User: cbowen
 * Date: 3/11/2016
 * Time: 8:32 PM
 */

namespace Noir;

/**
 * View class for the home page
 */
class HomeView extends View {
	/**
	 * DeleteView constructor.
	 * @param Site $site Site object
	 * @param array $get $_GET
	 * @param array $session $_SESSION
	 */
	public function __construct(Site $site, $get, $session) {
		parent::__construct($site, $get, $session);
		$this->setTitle("Film Noir Movies");
	}

	/**
	 * Present the page body
	 * @return string HTML for the page body
	 */
	public function present() {

		$html = <<<HTML
<form method="post" action="post/home.php">
    <p class="buttons"><input type="submit" name="new" value="New">
        <input type="submit" name="add" value="Add">
        <input type="submit" name="edit" value="Edit">
        <input type="submit" name="delete" value="Delete">
    </p>
    <table>
        <tr><th>&nbsp;</th><th>Title</th><th>Year</th><th>Rating</th></tr>
HTML;

		$movies = new Movies($this->site);
		$all = $movies->getAll();

		foreach($all as $movie) {
			$title = $movie->getTitle();
			$year = $movie->getYear();
			$rating = $movie->getRating();
			$id = $movie->getId();
			if($rating === null) {
				$stars = "not rated";
			} else {
				$stars = '<span class="stars">' .
					str_repeat("*", $rating) .
					'</span> <span class="num">' .
					$rating . '/10</span>';
			}

			$html .= <<<HTML
<tr><td><input type="radio" value="$id" name="id"></td>
<td>$title</td><td>$year</td><td>$stars</td>
</tr>
HTML;
		}

		$html .= <<<HTML
    </table>
HTML;

		$html .= $this->errorMsg();

		$html .= <<<HTML
    <div class="instructions">
    <p>New - Add a new record using the normal editing form.</p>
        <p>Add - Add a new record using a new movie form.</p>
        <p>Edit - Edit the selected movie.</p>
        <p>Delete - Delete the selected movie.</p>
    </div>

    <p class="download">This site's PHPStorm project is available for download: <a href="filmnoir.zip">filmnoir.zip</a></p>
</form>
HTML;

		return $html;
	}
}