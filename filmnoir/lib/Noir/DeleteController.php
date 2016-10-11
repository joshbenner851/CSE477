<?php

namespace Noir;

/**
 * Controller for the deletemovie page
 */
class DeleteController extends Controller {
	/**
	 * DeleteController constructor.
	 * @param Site $site The Site object
	 * @param array $_POST
	 * @param array $session $_SESSION
	 */
	public function __construct(Site $site, array $post, array &$session) {
		parent::__construct($site, $session);

		if(isset($post['ok']) && isset($post['id'])) {
			$id = strip_tags($post['id']);

			$movies = new Movies($this->site);
			$movies->delete($id);
		}

		//
		// And redirect back to home
		//
		$this->redirect = $site->getRoot();
	}
}