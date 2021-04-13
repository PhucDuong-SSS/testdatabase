<?php
namespace Test\ConnectDatabase;

use Exception;
use PDO;
use PDOException;

/**
 * Connect to database
 * Usable with MySQl, Postgres.
 */

class  ConnectDatabase {
    #Database object
    private $databaseObject;

    #Check connect
    public $isConnect;
    public $servername = "mariadb";
    public $username = "root";
    public $password = "123";

    public function __construct($username=DB_USER,$port=DB_PORT, $password=DB_PASSWORD, $host=DB_SERVER, $dbname=DB_NAME, $type = DB_MYSQL)
    {

        $this->isConnect = true;

        try {
            //New PDO Object (MySQL = mysql, Postgres = pgsql, ..)
            $this->databaseObject = new PDO("$type:host=$host; $port;$dbname", $username, $password);
            //Throw Error
            $this->databaseObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch (PDOException $e) {
            //What to do if error?
            $this->isConnect = false;
            echo "Connection failed: " . $e->getMessage();
        }
    }

    //Close connection
    public function disconnect()
    {
        $this->databaseObject = null;
        $this->isConnect = false;
    }

    //Select
    public function selectRows($query,$params=[])
    {
        try{
            $stmt = $this->databaseObject->prepare($query);
            $stmt->execute($params);
            if ($stmt->columnCount() == 1) $return = $stmt->fetch();
            else                           $return = $stmt->fetchAll();
            $stmt->closeCursor();
            return $return;
        }
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    //Select and get all rows

    public function getallRows($query,$params=[])
    {
        try{
            $stmt = $this->databaseObject->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        }
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }


    //Insert
    public function executeRow($query,$params=[])
    {
        try{
            $stmt = $this->databaseObject->prepare($query);
            $stmt->execute($params);
            $stmt->closeCursor();
            return true;
        }
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
            return false;
        }
    }

    //Update
    public function updateRow($query, $params=[])
    {
        try{
            return $this->executeRow($query, $params);
        }
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function addGuest( $name, $address, $phone ) {
		$sql = 'INSERT INTO  guestbook(name, address, phone)  VALUES(:name,:address,:phone)';

		$stmt = $this->pdo->prepare( $sql );
		$stmt->execute( [
			':name'    => $name,
			':address' => $address,
			':phone'   => $phone,
		] );
	}

}

