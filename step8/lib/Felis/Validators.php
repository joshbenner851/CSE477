<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/22/16
 * Time: 2:38 PM
 */

namespace Felis;


class Validators extends Table
{

    /**
     * Users constructor.
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        parent::__construct($site, "validator");
    }

    /**
	 * Create a new validator and add it to the table.
	 * @param $userid User this validator is for.
	 * @return The new validator.
	 */
	public function newValidator($userid) {
        $validator = $this->createValidator();

        // write to the table
        $table = $this->tableName;
        $sql = <<<SQL
insert into $table(userid, validator,date)
values ($userid,'$validator',now())
SQL;
		//echo $this->sub_sql($sql,array());
		// write to the table
		$pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();

        return $validator;
    }

    /**
	 * @brief Generate a random validator string of characters
	 * @param $len Length to generate, default is 32
	 * @returns Validator string
	 */
	private function createValidator($len = 32) {
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$l = strlen($chars) - 1;
		$str = '';
		for ($i = 0; $i < $len; ++$i) {
			$str .= $chars[rand(0, $l)];
		}
		return $str;
	}

    /**
	 * Determine if a validator is valid. If it is,
	 * get the user ID for that validator. Then destroy any
	 * validator records for that user ID. Return the
	 * user ID.
	 * @param $validator Validator to look up
	 * @return User ID or null if not found.
	 */
	public function getOnce($validator) {
        $sql = <<<SQL
select userid from $this->tableName
where validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));

        if($statement->rowCount() === 0) {
            return null;
        }

        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        $userid = $data['userid'];
        //var_dump($userid);

        $deleteSQL = <<<SQL
delete from $this->tableName
where userid=?
SQL;
        //$this->sub_sql($deleteSQL,array($validator));
        $statementDelete = $pdo->prepare($deleteSQL);
        $statementDelete->execute(array($userid));

        return $userid;
	}
}