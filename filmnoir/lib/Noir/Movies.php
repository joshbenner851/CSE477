<?php

namespace Noir;

/**
 * Class that represents the collection of movies and the movie table.
 */
class Movies extends Table {
	/**
	 * Constructor
	 * @param $site The Site object
	 */
	public function __construct(Site $site) {
		parent::__construct($site, "movie");
	}

	/**
	 * Ensure the movie table exists. If it  does not,
	 * create it.
	 */
	public function ensureExists() {
		$sql = <<<SQL
CREATE TABLE IF NOT EXISTS $this->tableName (
  id     int(10) NOT NULL AUTO_INCREMENT,
  title  varchar(300) NOT NULL UNIQUE,
  year   int(4) NOT NULL,
  rating int(2),
  PRIMARY KEY (id));

  insert into $this->tableName(title, year, rating)
  values("The Maltese Falcon", 1941, 10),
     ("Felis Noir", 2016, 8)
SQL;

		$this->site->pdo()->query($sql);
	}

	/**
	 * Get all movies in the system.
	 * @return array of all movies in the system.
	 */
	public function getAll() {
		$sql = <<<SQL
select * from $this->tableName
order by rating desc, title asc
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$stmt->execute();

		$movies = array();
		foreach($stmt as $row) {
			$movies[] = new Movie($row);
		}

		return $movies;
	}

	/**
	 * Add a movie to the table.
	 *
	 * The main reason for failure is a duplicate movie title,
	 * which causes a constraint violation.
	 * @param Movie $movie Movie to add
	 * @return bool True if successful
	 */
	public function add(Movie $movie) {
		$sql = <<<SQL
insert into $this->tableName(title, year, rating)
values(?, ?, ?)
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$ret = $stmt->execute(array($movie->getTitle(), $movie->getYear(), $movie->getRating()));

		if($ret === FALSE) {
			return false;
		}

		return $this->pdo()->lastInsertId();
	}

	/**
	 * Get a single movie by ID
	 * @param $id ID to look up
	 * @return Movie|null
	 */
	public function get($id) {
		$sql = <<<SQL
select * from $this->tableName
where id=?
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$stmt->execute(array($id));

		$movies = array();
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		if($row === null) {
			return null;
		}

		return new Movie($row);
	}

	/**
	 * Update a movie record
	 * @param Movie $movie Modified movie
	 * @return false on failure
	 */
	public function update(Movie $movie) {
		$sql = <<<SQL
update $this->tableName
set title=?, year=?, rating=?
where id=?
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$ret = $stmt->execute(array($movie->getTitle(), $movie->getYear(), $movie->getRating(), $movie->getId()));

		return $ret;
	}

	/**
	 * Delete a movie
	 * @param $id Id for the movie to delete
	 * @return false on failure
	 */
	public function delete($id) {
		$sql = <<<SQL
delete from $this->tableName
where id=?
SQL;

		$stmt = $this->pdo()->prepare($sql);
		$ret = $stmt->execute(array($id));

		return $ret;
	}
}