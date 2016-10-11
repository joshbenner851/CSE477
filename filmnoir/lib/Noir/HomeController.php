<?php

namespace Noir;

/**
 * Controller class for the home page
 */
class HomeController extends Controller {
	/**
	 * HomeController constructor.
	 * @param Site $site Site object
	 * @param array $post $_POST
	 * @param array $session $_SESSION
	 */
    public function __construct(Site $site, array $post, array &$session) {
        parent::__construct($site, $session);

        $root = $site->getRoot();
        if(isset($post['add'])) {
            /*
             * Add button pressed
             */
            $this->redirect = "$root/newmovie.php";
        } else if(isset($post['new'])) {
            /*
             * New button pressed
             */
            $this->redirect = "$root/movie.php";
        } else if(isset($post['edit'])) {
            /*
             * Edit button pressed
             */
            if(!isset($post['id'])) {
                $this->error("", "You must select a movie to edit.");
                return;
            }

            $id = strip_tags($post['id']);
            $this->redirect = "$root/movie.php?i=$id";
        } else if(isset($post['delete'])) {
            /*
             * Delete button pressed
             */
            if(!isset($post['id'])) {
                $this->error("", "You must select a movie to delete.");
                return;
            }

            $id = strip_tags($post['id']);
            $this->redirect = "$root/deletemovie.php?i=$id";
        } else {
            $this->redirect = "$root/";
        }
    }

}