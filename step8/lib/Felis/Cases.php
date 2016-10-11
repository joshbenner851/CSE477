<?php
/**
 * Created by PhpStorm.
 * User: joshbenner
 * Date: 3/21/16
 * Time: 12:44 AM
 */

namespace Felis;


class Cases extends Table
{

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site,"clientcase");
        $this->site = $site;

    }

    /**
     * Updates a case
     * @param $number
     * @param $summary
     * @param $agent
     * @param $status
     * @return ClientCase|null
     */
    public function update($id,$number,$summary,$agent,$status){
        $sql = <<<SQL
update $this->tableName
set number=?, summary=?,agent=?,status=?
WHERE id=?
SQL;

        //echo "sql" .  $this->sub_sql($sql, array($number,$summary,$agent,$status,$id));
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($number,$summary,$agent,$status,$id));
//        if($statement->rowCount() === 0) {
//            return false;
//        }
    }


    /**
     * Returns if the ID being changed already exists
     * @param $id
     * @return bool
     */
    public function checkID($id){
        $sql = <<<SQL
SELECT *
FROM s8_clientcase
WHERE number=?
SQL;
        //var_dump($sql);
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        //var_dump($statement->fetch(\PDO::FETCH_ASSOC));
        if($statement->rowCount() === 0) {
            return false;
        }
        return false;
    }

    public function delete($id){
        $sql = <<<SQL
delete from s8_clientcase
where id=?
SQL;
        //$this->sub_sql($sql,array($id));
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
    }

    /**
     * inserts a Client case into the database
     * @param $client
     * @param $agent
     * @param $number
     * @return null
     */
    public function insert($client, $agent, $number) {
        $sql = <<<SQL
insert into $this->tableName(client, agent, number, summary, status)
values(?, ?, ?, "", "")
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($client, $agent, $number)) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }

    /** Returns all the cases
     * @return array|null
     */
    public function getCases(){
        $users = new Users($this->site);
		$usersTable = $users->getTableName();

        $sql = <<<SQL
select distinct c.id, c.client, client.name as clientName,
       c.agent, agent.name as agentName,
       number, summary, status
from $usersTable as client, $usersTable as agent
inner join $this->tableName AS c
on c.agent=agent.id
where c.client = client.id
order by status desc, number
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return array();
        }
        $cases = $statement->fetchAll(\PDO::FETCH_ASSOC);
        //var_dump($cases);
        $casesArray = array();
        foreach($cases as $case){
            $clientcase = new ClientCase($case);
            array_push($casesArray,$clientcase);
        }
        return $casesArray;
    }

    /**
     * Get a case by id
     * @param $id The case by ID
     * @returns Case object if successful, null otherwise.
     */
    public function get($id) {
        $users = new Users($this->site);
		$usersTable = $users->getTableName();
        //var_dump($users);
		$sql = <<<SQL
SELECT c.id, c.client, client.name as clientName,
       c.agent, agent.name as agentName,
       number, summary, status
from $this->tableName c,
     $usersTable client,
     $usersTable agent
where c.client = client.id and
      c.agent=agent.id and
      c.id=?
SQL;
        //var_dump($sql);
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        //var_dump($statement->fetch(\PDO::FETCH_ASSOC));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new ClientCase($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function fetchID($caseNum){
        $sql = <<<SQL
SELECT id
FROM  s8_clientcase
WHERE number=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($caseNum));
        if($statement->rowCount() === 0) {
            return null;
        }
        $stuff = $statement->fetch(\PDO::FETCH_ASSOC);
        return $stuff['id'];
    }



    protected $site;


}