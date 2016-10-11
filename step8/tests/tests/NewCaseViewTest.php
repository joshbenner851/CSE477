<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class NewCaseViewTest extends \PHPUnit_Extensions_Database_TestCase
{
    public static function setUpBeforeClass(){
        self::$site = new Felis\Site();
        $localize = require 'localize.inc.php';
        if(is_callable($localize)){
            $localize(self::$site);
        }
    }

	/**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'bennerjo');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/clientcase.xml');
    }

    public function test_getClients() {
		$users = new Felis\Users(self::$site);

		$clients = $users->getClients();
        var_dump($clients);
		$this->assertEquals(2, count($clients));
		$c0 = $clients[0];
		$this->assertEquals(2, count($c0));
		$this->assertEquals(9, $c0['id']);
		$this->assertEquals("Simpson, Bart", $c0['name']);
		$c1 = $clients[1];
		$this->assertEquals(10, $c1['id']);
		$this->assertEquals("Simpson, Marge", $c1['name']);
	}

    private static $site;
}

/// @endcond
?>
