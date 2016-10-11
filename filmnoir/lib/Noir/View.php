<?php
namespace Noir;

/**
 * Base class for all views
 */
class View {
	/**
	 * Optional name to save an error message under in the session.
	 */
	const SESSION_ERROR = "filmnoir_error";

	/**
	 * View constructor.
	 * @param array $get $_GET
	 * @param array $session $_SESSION
	 */
	public function __construct(Site $site, array $get, array $session) {
		/*
		 * When I found that several pages needed $_GET and $_SESSION
		 * and error message handling, I found it easiest to just move
		 * that into the View base class.
		 */
		$this->site = $site;
		$this->get = $get;
		$this->session = $session;
	}

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header() {
        $html = <<<HTML
<header class="main">
    <h1>$this->title</h1>
</header>
HTML;
        return $html;
    }



    /**
     * Create the HTML for the page footer
     * @return string HTML for the standard page footer
     */
    public function footer()
    {
        return <<<HTML
<footer><p>Copyright © 2016 Felis Investigations, Inc. All rights reserved.</p></footer>
HTML;
    }

	/**
	 * Create the HTML for the contents of the head tag
	 * @return string HTML for the page head
	 */
	public function head() {
		return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="noir.css">
HTML;
	}

	/**
	 * Set the page title
	 * @param $title New page title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get any optional error messages
	 * @return string Optional error message HTML or empty if none.
	 */
    public function errorMsg() {
        if(isset($this->get['e']) && isset($this->session[self::SESSION_ERROR])) {
            return '<p class="error">' . $this->session[self::SESSION_ERROR] . '</p>';
        } else {
            return '';
        }
    }


	/**
	 * Get the redirect location link.
	 * @return page to redirect to.
	 */
	public function getRedirect() {
		return $this->redirect;
	}


	protected $site;		///< The Site object
	protected $session;		///< $_SESSION
	protected $get;			///< $_GET
	private $title = "";	///< The page title

	protected $redirect = null;	///< Optional redirect?
}