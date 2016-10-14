
<?php
$pdo;
try {
  $pdo = new PDO('mysql:host=mysql-user.cse.msu.edu;dbname=cse477s',
                'cse477sro',
                'Letmesql');
} catch(PDOException $e) {
  // If we can't connect we die!
  die("Unable to select database");
}


$sql = <<<SQL
select name, Percentage, IsOfficial
from Country
inner join CountryLanguage
on CountryLanguage.CountryCode=Country.Code
where Language LIKE ? and Percentage > 0  and (IsOfficial=? or IsOfficial=?)
SQL;
      $statement = $pdo->prepare($sql);
      $isOfficial = $_GET['official'];
      $isOff = "";
      if($isOfficial == "neither")
      {
        $isOff = "T";
        $isOfficial = "F";
      }
      else if($isOfficial == "yes"){
      $isOff = "T";
      $isOfficial = "T";
      }
      else{
      $isOff = "F";
      $isOfficial = "F";
      }


      $statement->execute(array($_GET['language'],$isOfficial,$isOff));
      $results = $statement->fetch(\PDO::FETCH_ASSOC);
      $html = "<table><tr><th>Country</th><th>Percentage</th><th>Official</th></tr>";
      foreach($statement as $row)
      {
            $official = "";
            if($row['IsOfficial'] == "T"){
                $official = "Yes";
            }
            else if($row['IsOfficial'] == "F"){
                $official = "No";
            }
            $html .= "<tr><td>" . $row['name'] . "</td>" . "<td>" . $row['Percentage'] . "</td>" . "<td>" . $official . "</td>";
     }
      $html .= "</table>";
      echo $html;

