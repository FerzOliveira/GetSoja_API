<?php

class ConnectionDB{
	
	function con(){
		$connect = mysqli_connect("localhost","root","")or die(mysqli_error()); //connect with db
		
		mysqli_select_db($connect,"db_safrateste")or die(mysqli_error()); //select db
	
		return $connect;
	}
}