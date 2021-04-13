<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;




class ConnectDatabaseTest extends TestCase {

  	/**
	 * @see https://phpunit.readthedocs.io/en/7.0/database.html#configuration-of-a-phpunit-database-testcase
	 *
	 * @return \PHPUnit\DbUnit\Database\DefaultConnection|null
	 */
	final public function getConnection() {

		if ( $this->conn === NULL ) {

			if ( $this->pdo == NULL ) {

				// this is all we need to connect to our non-persistent database, no user or password is required:
				$this->pdo = new PDO( 'sqlite::memory:' );

				// Because we're creating a completely new database in RAM, we have to create the required tables here.
				// Otherwise we'll get an error because PHPUnit will fail to truncate the tables before testing.
				// Note the SQLite syntax which differs from MySQL you might got merely used to.
				$sql = 'CREATE TABLE IF NOT EXISTS guestbook (
  							id INTEGER PRIMARY KEY AUTOINCREMENT, 
  							name VARCHAR (100) DEFAULT NULL,
  							address TEXT, 
  							phone VARCHAR(50))';
				$this->pdo->exec( $sql );
			}
			// $this->conn = $this->createDefaultDBConnection( $this->pdo, ':memory:' );
		}

		return $this->conn;
	}

}

//https://www.programmersought.com/article/61676263559/
