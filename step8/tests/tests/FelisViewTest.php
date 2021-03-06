<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class FelisViewTest extends \PHPUnit_Framework_TestCase
{
	public static function setUpBeforeClass(){
        self::$site = new Felis\Site();
        $localize = require 'localize.inc.php';
        if(is_callable($localize)){
            $localize(self::$site);
        }
    }

	public function test_footer() {
		$view = new Felis\View(self::$site,$_GET,$_SESSION);

		$this->assertContains('<footer><p>Copyright © 2016 Felis Investigations, Inc. All rights reserved.</p></footer>',$view->footer());
    }

    public function test_head(){
        $view = new Felis\View(self::$site,$_GET,$_SESSION);

        $view->setTitle("This is a fake title");
        $this->assertContains('<meta charset="utf-8">',$view->head());
        $this->assertContains('<meta name="viewport" content="width=device-width, initial-scale=1">',$view->head());
        $this->assertContains("<title>This is a fake title</title>", $view->head());
        $this->assertContains('<link rel="stylesheet" href="lib/css/felis.css">',$view->head());
    }

    public function test_header() {
        $view = new Felis\View(self::$site,$_GET,$_SESSION);
        $view->setTitle("whatever");
        $html = $view->header();

        $this->assertContains('<nav>', $html);
        $this->assertContains('<ul class="left">', $html);
        $this->assertContains('<li><a href="./">The Felis Agency</a></li>', $html);
        $this->assertContains('</ul>', $html);
        $this->assertContains('</nav>', $html);
        $this->assertContains('<header class="main">', $html);
        $this->assertContains('<h1><img src="images/comfortable.png" alt="Felis Mascot"> whatever', $html);
        $this->assertContains('<img src="images/comfortable.png" alt="Felis Mascot"></h1>', $html);
        $this->assertContains('</header>', $html);

        $this->assertNotContains('<ul class="right">', $html);
    }

    public function test_addLink() {
        $view  = new Felis\View(self::$site,$_GET,$_SESSION);
        $view->setTitle("whatever");
        $view->addLink("test.php", "Name to Display");
        $html = $view->header();
        $this->assertContains('<ul class="right"><li><a href="test.php">Name to Display</a></li></ul>', $html);
    }
    private static $site;
}


/// @endcond
?>
