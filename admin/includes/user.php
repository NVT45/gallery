<?php 

class User {
		protected static $db_table = "users";
		protected static $db_table_fields = array('username','password','first_name','last_name');//
		public $id;
		public $username;
		public $password;
		public $first_name;
		public $last_name;


public static function find_all(){


	return self::find_this_query("SELECT * FROM " . self::$db_table . " ");


}

public static function find_by_id($user_id){

	global $database;

	$the_result_array = self::find_this_query("SELECT * FROM " . self::$db_table . " WHERE id = $user_id LIMIT 1");

	
	return !empty($the_result_array) ? array_shift($the_result_array) : false;

}

public static function verify_user($username, $password){

	global $database;
	$username = $database->escape_string($username);
	$password = $database->escape_string($password);

	$sql = "SELECT * FROM " . self::$db_table . " WHERE "; // TIps not space " "
	$sql .= "username = '{$username}' ";
	$sql .= "AND password = '{$password}' ";
	$sql .= "LIMIT 1";
	$the_result_array = self::find_this_query($sql);
	return !empty($the_result_array) ? array_shift($the_result_array) : false;

}

public static function find_this_query($sql){

	global $database;

	$result_set = $database->query($sql);

	$the_object_array = array();

	while ($row = mysqli_fetch_array($result_set)) {
		$the_object_array[] =self::instantation($row);
	}

	return $the_object_array;

}

public static function instantation($the_record){

	$the_object = new self;

	// $the_object->id         = $found_user['id'];
	// $the_object->username   = $found_user['username'];
	// $the_object->password   = $found_user['password'];
	// $the_object->first_name = $found_user['first_name'];
	// $the_object->last_name  = $found_user['last_name'];


	foreach ($the_record as $the_attribute => $value) {
		if ($the_object->has_the_attribute($the_attribute)) {
			$the_object->$the_attribute = $value;
		}
	}

	return $the_object;


}

public function has_the_attribute($the_attribute){
	$object_properties = get_object_vars($this);
	return array_key_exists($the_attribute, $object_properties);
}

public function properties(){
	//return get_object_vars($this);

	$properties = array();
	foreach (self::$db_table_fields as $db_fields) {
		if(property_exists($this, $db_fields)){
			$properties[$db_fields] = $this->$db_fields;
		}
	}
	return $properties;
}

public function clean_properties(){
	global $database;

	$clean_propeties  = array();
	foreach ($this->properties() as $key => $value) {
		$clean_propeties[$key] = $database->escape_string($value);
	}
	return $clean_propeties;
}

public function save(){
	return isset($this->id) ? $this->update() : $this->create();
}
public function create(){
	global $database;
	$properties = $this->clean_properties();
	$sql = "INSERT INTO ".self::$db_table."(" . implode(",", array_keys($properties))  .")";
	$sql.= " VALUES ('". implode("','", array_values($properties)). "')";
	// $sql.= $database->escape_string($this->username)."', '" ;
	// $sql.= $database->escape_string($this->password)."', '" ;
	// $sql.= $database->escape_string($this->first_name)."', '" ;
	// $sql.= $database->escape_string($this->last_name)."' ) " ; 
	if ($database->query($sql)) {
		$this->id = $database->the_insert_id();
		return true;
	}else {
		return false;
	}

 }
public function update(){
	global $database;
	$properties = $this->clean_properties();
	$properties_pair = array();
	foreach ($properties as $key => $value) {
		$properties_pair[] = "{$key} = '{$value}'";
	}
	$sql = " UPDATE ".self::$db_table." SET ";
	$sql .= implode(",",$properties_pair);
	$sql .= " WHERE id= ".$database->escape_string($this->id);
	$database->query($sql);
	return (mysqli_affected_rows($database->connection) == 1) ? true :false ;
	

}

public function delete(){
	global $database;
	$sql = "DELETE FROM ".self::$db_table." ";
	$sql .= " WHERE id= ".$database->escape_string($this->id);
	$sql .= " LIMIT 1";
	$database->query($sql);
	return (mysqli_affected_rows($database->connection) == 1) ? true :false ;
}
	
}


 ?>