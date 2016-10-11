<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/10/16
 * Time: 11:21 PM
 */

namespace Felis;


class View
{

    public function __construct(Site $site, array $get, array $session)
    {
        $this->get = $get;
        $this->site = $site;
        $this->session = $session;
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
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
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
<link rel="stylesheet" href="lib/css/felis.css">
HTML;
    }

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header() {
        $html = <<<HTML
<nav>
    <ul class="left">
        <li><a href="./">The Felis Agency</a></li>
    </ul>
HTML;

        $additional = $this->headerAdditional();
        if(count($this->links) > 0){
            $html .= '<ul class="right">';
            foreach($this->links as $link){
                $html .= '<li><a href="' .
                    $link['href'] . '">' .
                    $link['text'] . '</a></li>';

            }
            $html .= '</ul>';
        }

        $html .= <<<HTML
</nav>
<header class="main">
    <h1><img src="images/comfortable.png" alt="Felis Mascot"> $this->title
    <img src="images/comfortable.png" alt="Felis Mascot"></h1>
    $additional
</header>
HTML;
        return $html;
    }


    /**
     * Add a link that will appear on the nav bar
     * @param $href What to link to
     * @param $text
     */
    public function addLink($href, $text){
        $this->links[] = array("href" => $href, "text" => $text);
    }

    /**
     * Override in derived class to add content to the header.
     * @return string Any additional comment to put in the header
     */
    protected function headerAdditional() {
        return '';
    }

    /**
     * Protect a page for staff only access
     *
     * If access is denied, call getProtectRedirect
     * for the redirect page
     * @param $site The Site object
     * @param $user The current User object
     * @return bool true if page is accessible
     */
    public function protect($site, $user) {
        if($user->isStaff()) {
            return true;
        }

        $this->protectRedirect = $site->getRoot() . "/";
        return false;
    }

    /**
     * Get any redirect page
     */
    public function getProtectRedirect() {
        return $this->protectRedirect;
    }

    /// Page protection redirect
    private $protectRedirect = null;
    private $links = array(); ///< Links to add to the nav bar
    private $title = "";	///< The page title
    protected $get; //< $_GET
    protected $session;
    protected $site;
}