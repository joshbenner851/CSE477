<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class UsersTest extends \PHPUnit_Extensions_Database_TestCase
{
    public static function setUpBeforeClass(){
        self::$site = new Felis\Site();
        $localize = require 'localize.inc.php';
        if(is_callable($localize)){
            $localize(self::$site);
        }
    }

    public function test_construct() {
        $validators = new Felis\Validators(self::$site);
        $this->assertInstanceOf('Felis\Validators', $validators);
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

    public function test_newValidator() {
        $validators = new Felis\Validators(self::$site);

        $validator = $validators->newValidator(27);
        $this->assertEquals(32, strlen($validator));

        $table = $validators->getTableName();
        var_dump($table);
        $sql = <<<SQL
select * from $table
where userid=? and validator='$validator'
SQL;

        $stmt = $validators->pdo()->prepare($sql);
        $stmt->execute(array(27));
        $this->assertEquals(1, $stmt->rowCount());
    }

    private static $site;
}

/// @endcond
?>
