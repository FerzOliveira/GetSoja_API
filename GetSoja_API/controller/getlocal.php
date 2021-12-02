<?php
require_once($_SERVER['DOCUMENT_ROOT']."/safra/model/connect.php");

$date = $_POST['date'];
		
$obj_con = new ConnectionDB;
$connect = $obj_con->con();
		
$today = date("y-m-d");
		
$sqlGet = "SELECT localSoja from soja_tbl WHERE dataSoja = '".$date."'";
$locations = mysqli_query($connect, $sqlGet);

		
	
	
	
