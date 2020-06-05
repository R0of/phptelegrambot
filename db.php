<?php
header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Tashkent');
////////////Baza bilan bog'lanamiz
require_once ("botcore.php");

class Database { 
	private $db;
	private $senda;
    public function __construct(){
    	$this->db = new mysqli("localhost","usernameDB","passwordDB","nameDB");
    	$this->senda = new sendtoteleg();
    	
    	if(mysqli_connect_errno()){
    		$this->senda->sendteleg($data = ['text'=>"Error with DB:"
    		. mysqli_connect_errno()], $GLOBALS['admin_id'], "sendMessage" );
         	exit;
       	}
    }
    public function isRegistered($user_id) {
        $query = "SELECT * FROM user WHERE user_id = $user_id";
        $result = $this->db->query($query);
        $num_results = $result->num_rows;
        if ($num_results>0) {
            return true;
        } else {
            return false;
        }
    }
    public function register($user_id,$username,$first_name,$last_name) {
    	$date = date("Y-m-d H:i:s");
        $stmt = $this->db->prepare("INSERT INTO user ( user_id,username,first_name,last_name,created) 
        VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss",$user_id,$username,$first_name,$last_name,$date); 
        $result = $stmt->execute();
        if (!$result) {
            return false;
        } else {
            return true;
        }
        $stmt->close();
    } 
