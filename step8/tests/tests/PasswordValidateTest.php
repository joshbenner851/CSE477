<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class PasswordValidateTest extends \PHPUnit_Framework_TestCase
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
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/validator.xml');
    }

	public function test_getOnce() {
		$validators = new Felis\Validators(self::$site);

		// Test a not-found condition
		$this->assertNull($validators->getOnce(""));

		// Create two validators
		// Either can work, but only one time!
		$validator1 = $validators->newValidator(27);
		$validator2 = $validators->newValidator(27);

		$this->assertEquals(27, $validators->getOnce($validator1));
		$this->assertNull($validators->getOnce($validator1));
		$this->assertNull($validators->getOnce($validator2));

		// Create two validators
		// Either can work, but only one time!
		$validator1 = $validators->newValidator(33);
		$validator2 = $validators->newValidator(33);

		$this->assertEquals(33, $validators->getOnce($validator2));
		$this->assertNull($validators->getOnce($validator1));
		$this->assertNull($validators->getOnce($validator2));
    }

	private static $site;
}

/// @endcond
?>
