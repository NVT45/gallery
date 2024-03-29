<?php 

class Db_object {
	public $errors = array();
	public $upload_errors_array = array(
		UPLOAD_ERR_OK => "There is no error, the file uploaded with success",
		UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive", 
		UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
		UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
		UPLOAD_ERR_NO_FILE =>" No file was uploaded",
		UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder", 
		UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
		UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload"


		);
		
public function set_file($file){

			if(empty($file) || !$file || !is_array($file)){
				$this->errors[] = "These was no file uploaded here";
				return false;
			}elseif ($file['error'] !=0) {
				$this->errors[] = $this->upload_errors_array[$file['error']];
				return false;
			}
			else{
			$this->user_image = basename($file['name']);
			$this->tmp_path = $file['tmp_name'];
			$this->type = $file['type'];
			$this->size = $file['size'];

			}

			
		}
	public static function find_all(){


	return static::find_this_query("SELECT * FROM " . static::$db_table . " ");


}

public static function find_by_id($id){

	global $database;

	$the_result_array = static::find_this_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");

	
	return !empty($the_result_array) ? array_shift($the_result_array) : false;


}

public static function find_this_query($sql){

	global $database;

	$result_set = $database->query($sql);

	$the_object_array = array();

	while ($row = mysqli_fetch_array($result_set)) {
		$the_object_array[] =static::instantation($row);
	}

	return $the_object_array;

}
public static function instantation($the_record){

	$calling_class = get_called_class();

	$the_object = new $calling_class;

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
	foreach (static::$db_table_fields as $db_fields) {
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
	$sql = "INSERT INTO ".static::$db_table."(" . implode(",", array_keys($properties))  .")";
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
	$sql = " UPDATE ".static::$db_table." SET ";
	$sql .= implode(",",$properties_pair);
	$sql .= " WHERE id= ".$database->escape_string($this->id);
	$database->query($sql);
	return (mysqli_affected_rows($database->connection) == 1) ? true :false ;
	

}

public function delete(){
	global $database;
	$sql = "DELETE FROM ".static::$db_table." ";
	$sql .= " WHERE id= ".$database->escape_string($this->id);
	$sql .= " LIMIT 1";
	$database->query($sql);
	return (mysqli_affected_rows($database->connection) == 1) ? true :false ;
}

public static function count_all(){
	global $database;
	$sql = "SELECT count(*) FROM ".static::$db_table;
	$result_set = $database->query($sql);
	$row = mysqli_fetch_array($result_set);
	return array_shift($row);

}

}




 ?>