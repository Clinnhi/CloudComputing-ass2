<?php 

// Need to change this file - code for phpmyadmin

class DB{
	private $con;
	private $host = "localhost";
	private $dbname = "livesearch";
	private $user = "root";
	private $password = "";

	public function __construct(){
		$dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;

		try{
			$this->con = new PDO($dsn, $this->user, $this->password);
			$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// echo "Connection Successful";

		}catch(PDOException $e){
			echo "Connection Failed: " . $e->getMessage(); 
		}
	}

	public function viewData(){
		$query = "SELECT name FROM names";
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}


// Searches name that contains the letters that the user search
// E.g. "Pham" will bring up Clinton Pham, Albert Pham, Charlie Pham
	public function searchData($name){
		$query = "SELECT name FROM names WHERE name LIKE :name";
		$stmt = $this->con->prepare($query);
		$stmt->execute(["name" => "%" . $name . "%"]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
}	
 ?>
