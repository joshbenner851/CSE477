<?php

namespace Noir;

/**
 * Controller class for the new movie page
 */
class NewMovieController extends Controller {

	/**
	 * HomeController constructor.
	 * @param Site $site Site object
	 * @param array $post $_POST
	 * @param array $session $_SESSION
	 */
	public function __construct(Site $site, $post, &$session) {
		parent::__construct($site, $session);

		$root = $site->getRoot();
		if(isset($post['ok'])) {
			// The OK button was pressed
			// Get the values and do some error checking
			$title = trim(strip_tags($post['title']));
			if($title === '') {
				// No title entered
				$this->error("newmovie.php", "No title entered");
				return;
			}

			$year = trim(strip_tags($post['year']));
			if($year === '') {
				$this->error("newmovie.php", "No year entered");
				return;
			}

			if(!is_numeric($year)) {
				$this->error("newmovie.php", "Invalid year entered");
				return;
			}

			$year = intval($year);
			if($year < 1800 || $year > 2100) {
				$this->error("newmovie.php", "Invalid year entered");
				return;
			}

			//
			// Create the movie object
			//
			$row = array("id" => 0, "title" => $title, "year" => $year, "rating" => null);
			$movie = new Movie($row);

			//
			// Try to insert
			//
			$movies = new Movies($this->site);
			$id = $movies->add($movie);
			if($id === false) {
				$this->error("newmovie.php", "Unable to add movie, name already exists");
				return;
			}

			//
			// And redirect to edit it
			//
			$this->redirect = "$root/movie.php?i=" . $id;
		} else {
			// Cancel was pressed, just return to the home page
			$this->redirect = "$root/";
		}

	}



}