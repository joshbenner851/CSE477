<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class SiteTest extends \PHPUnit_Framework_TestCase
{
	public function test1() {
		//$this->assertEquals($expected, $actual);
	}

	public function test_gettersSetters()
	{
		$site = new Felis\Site();
		$site->dbConfigure("stretch","josh","acbd","prefix4days");

		$site->setEmail("fake@gmail.com");
		$this->assertContains("fake@gmail.com",$site->getEmail());

		$site->setRoot("abcdef");
		$this->assertContains("abcdef",$site->getRoot());
		$this->assertContains("prefix4days",$site->getTablePrefix());
	}

	public function test_localize() {
		$site = new Felis\Site();
		$localize = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize($site);
		}
		echo $site->getTablePrefix();
		$this->assertEquals('test_', $site->getTablePrefix());
	}

}

/// @endcond
?>
