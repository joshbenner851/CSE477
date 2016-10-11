<?php
/**
 * Created by PhpStorm.
 * User: cbowen
 * Date: 3/11/2016
 * Time: 8:32 PM
 */

namespace Noir;

/**
 * View class for the new movie page
 */
class NewMovieView extends View {
	/**
	 * DeleteView constructor.
	 * @param Site $site Site object
	 * @param array $get $_GET
	 * @param array $session $_SESSION
	 */
	public function __construct(Site $site, array $get, array $session) {
		parent::__construct($site, $get, $session);
		$this->setTitle("Film Noir New Movie");
	}

	/**
	 * Present the page body
	 * @return string HTML for the page body
	 */
	public function present() {
		$html = <<<HTML
<form class="movie" method="post" action="post/newmovie.php">
	<fieldset>
		<p><label for="title">Title: </label>
		<input type="text" id="title" name="title"></p>
		<p><label for="year">Year: </label>
			<input type="text" id="year" name="year"></p>
		<p class="buttons"><input type="submit" name="ok" value="OK">
			<input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
</form>
HTML;

		$html .= $this->errorMsg();

		return $html;
	}


}