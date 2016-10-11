<?php
namespace Noir;

/**
 * View class for the deletemovie page
 */
class DeleteView extends View {
	/**
	 * DeleteView constructor.
	 * @param Site $site Site object
	 * @param array $get $_GET
	 * @param array $session $_SESSION
	 */
	public function __construct(Site $site, array $get, array $session) {
		parent::__construct($site, $get, $session);
		$this->setTitle("Film Noir Movie Delete?");

		$this->title = '';
		$this->id = null;

		if(isset($this->get['i'])) {
			// Editing an existing movie
			$movies = new Movies($this->site);
			$movie = $movies->get($this->get['i']);
			if($movie !== null) {
				$this->title = $movie->getTitle();
				$this->id = $movie->getId();
			}
		}

		if($this->id === null) {
			$root = $this->site->getRoot();
			$this->redirect = "$root/";
			return;
		}
	}

	/**
	 * Present the page body
	 * @return string HTML for the page body
	 */
	public function present() {

		$html = <<<HTML
<form class="movie" method="post" action="post/deletemovie.php">
<input type="hidden" name="id" value="$this->id">
	<fieldset>
		<p>Are you sure you want to delete:<br>
		$this->title</p>
		<p class="buttons"><input type="submit" name="ok" value="OK">
			<input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
</form>
HTML;

		$html .= $this->errorMsg();

		return $html;
	}

	private $title;
	private $id;
}